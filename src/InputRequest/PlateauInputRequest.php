<?php

declare(strict_types=1);

namespace MarsRover\InputRequest;

/**
 * Class PlateauCommand
 * @package MarsRover\Command
 */
class PlateauInputRequest implements InputRequestInterface
{
    /**
     * PlateauCommand constructor.
     * @param int $x
     * @param int $y
     */
    public function __construct(private int $x, private int $y)
    {
    }

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
