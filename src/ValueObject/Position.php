<?php

declare(strict_types=1);

namespace MarsRover\ValueObject;

use Assert\Assertion;
use MarsRover\Domain\Plateau;
use MarsRover\Exceptions\InvalidDirectionException;

/**
 * Class Position
 * in php 8.1 we can define enum, but here I use 8.0
 * @package MarsRover\ValueObject
 */
class Position
{
    /**
     * Position constructor.
     * @param int $x
     * @param int $y
     */
    public function __construct(private int $x, private int $y)
    {
        Assertion::greaterOrEqualThan($this->x, 0, 'plateau is a limited area 0,0');
        Assertion::greaterOrEqualThan($this->y, 0, 'plateau is limited area 0,0');
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param Plateau $plateau
     * @return bool
     */
    public function isOnPlateau(Plateau $plateau): bool
    {
        if ($this->x < 0 || $this->x > $plateau->getDimX()) {
            return false;
        }

        if ($this->y < 0 || $this->y > $plateau->getDimY()) {
            return false;
        }
        return true;
    }

    /**
     * @param Direction $direction
     */
    public function moveForward(Direction $direction) :void
    {
        match ((string)$direction) {
            Direction::E => $this->x++,
            Direction::N => $this->y++,
            Direction::S => $this->y--,
            Direction::W => $this->x--,
            default => throw new InvalidDirectionException('Unexpected match value')
        };
    }

    /**
     * @param Position $position
     * @return bool
     */
    public function isEqual(Position $position): bool
    {
        return ($this->x == $position->getX() && $this->y == $position->getY());
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->x . ' ' . $this->y;
    }
}
