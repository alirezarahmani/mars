<?php

namespace Boot;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;

/**
 * Class Mars
 * This class is responsible to boot Mars project
 * @package Boot
 */
class Mars
{
    /**
     * @throws \Exception
     */
    public function explode(): void
    {
        if (PHP_SAPI == "cli") {
            $this->runCli(new ArgvInput(), new ConsoleOutput());
        } else {
             throw new \Exception(' we only support CLI');
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \ReflectionException
     */
    private function runCli(InputInterface $input, OutputInterface $output): void
    {
        $application = new Application();
        $application->setAutoExit(false);
        $application->setCatchExceptions(false);
        foreach ($this::loadConsoleApplications(__DIR__ . '/../')['classes'] as $class) {
            $application->add(new $class());
        }
        try {
            $application->run($input, $output);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * create mars project
     * @return Mars
     */
    public static function create()
    {
        return new self();
    }

    /**
     * load all console classes
     * @param string $appPath
     * @return array[]
     * @throws \ReflectionException
     */
    private static function loadConsoleApplications(string $appPath): array
    {
        $classes = [];
        $dir = $appPath . '/src/Cli';
        if (!is_dir($dir)) {
            throw new \InvalidArgumentException('not a valid directory');
        }
        $finder = new Finder();

        foreach ($finder->files()->name('*Cli.php')->in($dir) as $file) {
            /**
             * @var \SplFileInfo $file
             */
            $className = 'MarsRover\\Cli\\'.substr($file->getRelativePathname(), 0, -4);
            $reflection = new \ReflectionClass($className);
            if ($reflection->isInstantiable()) {
                $classes[] = $className;
            }
        }
        return ['classes' => $classes];
    }
}
