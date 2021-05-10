<?php

declare(strict_types=1);

namespace MarsRover\Cli;

use Assert\Assert;
use Assert\Assertion;
use MarsRover\Command\MarsRoverCommand;
use MarsRover\Command\PlateauCommand;
use MarsRover\Domain\MarsRover;
use MarsRover\Domain\Plateau;
use MarsRover\Handler\MarsRoverHandler;
use MarsRover\Handler\PlateauHandler;
use MarsRover\ValueObject\Direction;
use MarsRover\ValueObject\Position;
use MarsRover\ValueObject\RoverMove;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

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

    protected function configure()
    {
        $this
            ->setName('mars:rover')
            ->setDescription('move mars rovers over mars!')
            ->addArgument('arguments', InputArgument::IS_ARRAY |InputArgument::REQUIRED, 'Enter moves of Mars Rover (separate actions with a space)');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $args = $input->getArgument('arguments');
        Assertion::notEmpty($args, 'make sure you entered right arguments');
        Assertion::true(count($args) >= 6 && ((count($args)-2) % 4) === 0, 'check your input');

        $plateauCoordinatesX = intval(array_shift($args));
        $plateauCoordinatesY = intval(array_shift($args));

        $plateauCommand = new PlateauCommand($plateauCoordinatesX, $plateauCoordinatesY);
        $plateau = (new PlateauHandler($plateauCommand))->getPlateau();

        for ($i = 0; $i < count($args); $i+=4) {
            $command = new MarsRoverCommand(intval($args[$i]), intval($args[$i+1]), $args[$i+2], $args[$i+3], $plateau);
            $roverHandler = new MarsRoverHandler($command);
            $output->writeln($roverHandler->reportPosition());
        }

        return 1;
    }
}
