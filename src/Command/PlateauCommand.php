<?php

declare(strict_types=1);

namespace MarsRover\Command;

use MarsRover\ValueObject\Direction;
use MarsRover\ValueObject\Position;
use MarsRover\ValueObject\RoverMove;

class PlateauCommand implements CommandInterface
{
    public function __construct(private int $x, private int $y)
    {}

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }
}
