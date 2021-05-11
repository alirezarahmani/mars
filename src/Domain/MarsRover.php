<?php

declare(strict_types=1);

namespace MarsRover\Domain;

use MarsRover\Exceptions\PositionNotOnPlateauException;
use MarsRover\ValueObject\Direction;
use MarsRover\ValueObject\Position;
use MarsRover\ValueObject\RoverMove;
use MarsRover\Exceptions\InvalidDirectionException;

/**
 * Class MarsRover
 *
 * @package MarsRover\Domain
 */
final class MarsRover
{
    /**
     * MarsRover constructor.
     * @param Position $position
     * @param Direction $heading
     * @param Plateau $plateau
     */
    public function __construct(private Position $position, private Direction $heading, private Plateau $plateau)
    {
        if ($this->position->isOnPlateau($plateau) === false) {
            throw new PositionNotOnPlateauException('Position not on plateau');
        }

        if ($this->plateau->isOccupied($this->position)) {
            throw new \RuntimeException('Already occupied by a rover!');
        }
        $this->plateau->addRover($this);
    }

    /**
     * @param RoverMove $roverMove
     */
    public function move(RoverMove $roverMove): void
    {
        // in php 8.1 we can define enum, but here I use 8.0 had to type cast
        switch ((string)$roverMove) {
            case RoverMove::R:
                $this->turnRight();
                break;
            case RoverMove::L:
                $this->turnLeft();
                break;
            case RoverMove::M:
                $this->moveForward();
                break;
        }
    }

    /**
     * turn a rover
     */
    public function turnLeft(): void
    {
        // in php 8.1 we can define enum, but here I use 8.0 had to type cast
        $this->heading = match ((string)$this->heading) {
            Direction::N => new Direction('W'),
            Direction::W => new Direction('S'),
            Direction::E => new Direction('N'),
            Direction::S => new Direction('E'),
            default => throw new InvalidDirectionException('Unexpected match value')
        };
    }

    /**
     * send current position
     * @return string
     */
    public function reportPosition(): string
    {
        return $this->position . ' ' . $this->heading;
    }

    /**
     * @return Position
     */
    public function currentPosition(): Position
    {
        return $this->position;
    }

    /**
     * turn rover
     */
    private function turnRight(): void
    {
        // in php 8.1 we can define enum, but here I use 8.0 had to type cast
        $this->heading = match ((string)$this->heading) {
            Direction::N => new Direction('E'),
            Direction::W => new Direction('N'),
            Direction::E => new Direction('S'),
            Direction::S => new Direction('W'),
            default => throw new InvalidDirectionException('Unexpected match value')
        };
    }

    /**
     * move the rover
     */
    private function moveForward(): void
    {
        $this->position->moveForward($this->heading);
    }
}
