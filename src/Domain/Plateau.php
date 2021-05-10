<?php

declare(strict_types=1);

namespace MarsRover\Domain;

use Assert\Assertion;
use MarsRover\ValueObject\Position;

class Plateau
{
    private array $rovers = [];

    public function __construct(private int $dimX, private int $dimY)
    {
        Assertion::greaterOrEqualThan($this->dimX, 4, 'X is too small for plateau');
        Assertion::greaterOrEqualThan($this->dimY, 4, 'Y is too small for plateau');
    }

    public function addRover(MarsRover $rover)
    {
        Assertion::true(
            $rover->currentPosition()->isOnPlateau($this),
            'You can not add rover, rover\'s position: ' . $rover->currentPosition() . ' is not on plateau!'
        );
        $this->rovers[] = $rover;
    }

    /**
     * @param Position $position
     * @return bool
     */
    public function isOccupied(Position $position)
    {
        /** @var MarsRover $rover */
        foreach ($this->rovers as $rover) {
            if ($rover->currentPosition()->isEqual($position)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return int
     */
    public function getDimX(): int
    {
        return $this->dimX;
    }

    /**
     * @return int
     */
    public function getDimY(): int
    {
        return $this->dimY;
    }
}
