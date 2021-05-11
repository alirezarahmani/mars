<?php

declare(strict_types=1);

namespace MarsRover\Cli;

use Assert\Assertion;
use MarsRover\Command\MarsRoverCommand;
use MarsRover\Command\PlateauCommand;
use MarsRover\Handler\MarsRoverHandler;
use MarsRover\Handler\PlateauHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MarsRoveCli
 * @package MarsRover\Cli
 */
class MarsRoveCli extends Command
{
    /**
     * MarsRoveCli constructor.
     */
    public function __construct()
    {
        parent::__construct(null);
        $this->addOption('force');
    }

    protected function configure(): void
    {
        $this
            ->setName('mars:rover')
            ->setDescription('move mars rovers over mars!')
            ->addArgument(
                'arguments',
                InputArgument::IS_ARRAY|InputArgument::REQUIRED,
                'Enter moves of Mars Rover (separate actions with a space)'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Assert\AssertionFailedException
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var array $args */
        $args = $input->getArgument('arguments');
        Assertion::notEmpty($args, 'make sure you entered right arguments');
        // make sure input format is correct
        Assertion::true(count($args) >= 6 && ((count($args)-2) % 4) === 0, 'check your input');

        // get plateau coordination
        $plateauCoordinatesX = intval(array_shift($args));
        $plateauCoordinatesY = intval(array_shift($args));

        // dispatch plateau manually
        // no command bus
        $plateauCommand = new PlateauCommand($plateauCoordinatesX, $plateauCoordinatesY);
        $plateau = (new PlateauHandler($plateauCommand))->getPlateau();

        // iterate over all rovers positions and headings
        for ($i = 0; $i < count($args); $i+=4) {
            // get arguments with order
            // i= X  i+1= Y i+2= Heading i+3= movements
            $command = new MarsRoverCommand(intval($args[$i]), intval($args[$i+1]), $args[$i+2], $args[$i+3], $plateau);
            $roverHandler = new MarsRoverHandler($command);
            $output->writeln($roverHandler->reportPosition());
        }

        return 1;
    }
}
