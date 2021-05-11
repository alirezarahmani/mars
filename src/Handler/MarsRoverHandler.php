<?php

declare(strict_types=1);

namespace MarsRover\Handler;

use MarsRover\Command\MarsRoverCommand;
use MarsRover\Domain\MarsRover;
use MarsRover\ValueObject\RoverMove;

/**
 * Class MarsRoverHandler
 * @package MarsRover\Handler
 */
class MarsRoverHandler
{
    /**
     * @var MarsRover
     */
    private MarsRover $marsRover;

    /**
     * MarsRoverHandler constructor.
     * @param MarsRoverCommand $command
     */
    public function __construct(private MarsRoverCommand $command)
    {
        $this->marsRover = new MarsRover(
            $this->command->getPosition(),
            $this->command->getRoverDirection(),
            $this->command->getPlateau()
        );
        $moves = $this->command->getMoves();
        /** @var RoverMove $move */
        foreach ($moves as $move) {
            $this->marsRover->move($move);
        }
    }

    /**
     * @return string
     */
    public function reportPosition(): string
    {
        return $this->marsRover->reportPosition();
    }
}
