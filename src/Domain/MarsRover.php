<?php

declare(strict_types=1);

namespace MarsRover\Domain;

use Assert\Assertion;
use MarsRover\Exceptions\PositionNotOnPlateauException;
use MarsRover\ValueObject\Direction;
use MarsRover\ValueObject\Position;
use MarsRover\ValueObject\RoverMove;
use MarsRover\Exceptions\InvalidDirectionException;

class MarsRover
{
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

    public function move(RoverMove $roverMove)
    {
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

    public function turnLeft()
    {
        $this->heading = match ((string)$this->heading) {
            Direction::N => new Direction('W'),
            Direction::W => new Direction('S'),
            Direction::E => new Direction('N'),
            Direction::S => new Direction('E'),
            default => throw new InvalidDirectionException('Unexpected match value')
        };
    }

    public function reportPosition(): string
    {
       return $this->position . ' ' . $this->heading;
    }

    public function currentPosition(): Position
    {
       return $this->position;
    }

    private function turnRight()
    {
        $this->heading = match ((string)$this->heading) {
            Direction::N => new Direction('E'),
            Direction::W => new Direction('N'),
            Direction::E => new Direction('S'),
            Direction::S => new Direction('W'),
            default => throw new InvalidDirectionException('Unexpected match value')
        };
    }

    private function moveForward()
    {
        $this->position->moveForward($this->heading);
    }
}
