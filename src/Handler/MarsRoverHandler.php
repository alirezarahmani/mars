<?php

declare(strict_types=1);

namespace MarsRover\Handler;

use MarsRover\Command\CommandInterface;
use MarsRover\Command\MarsRoverCommand;
use MarsRover\Domain\MarsRover;
use MarsRover\ValueObject\Direction;
use MarsRover\ValueObject\Position;
use MarsRover\ValueObject\RoverMove;

/**
 * Class MarsRoverHandler
 * @package MarsRover\Handler
 */
class MarsRoverHandler
{
    private MarsRover $marsRover;

    public function __construct(private MarsRoverCommand $command)
    {
        $this->marsRover = new MarsRover($this->command->getPosition(), $this->command->getRoverDirection(), $this->command->getPlateau());
        $moves = $this->command->getMoves();
        /** @var RoverMove $move */
        foreach ($moves as $move) {
            $this->marsRover->move($move);
        }
    }

    public function reportPosition(): string
    {
        return $this->marsRover->reportPosition();
    }
}
