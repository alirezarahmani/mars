<?php

declare(strict_types=1);

namespace MarsRover\Handler;

use MarsRover\Command\PlateauCommand;
use MarsRover\Domain\Plateau;

/**
 * Class PlateauHandler
 * @package MarsRover\Handler
 */
class PlateauHandler
{
    /**
     * PlateauHandler constructor.
     * @param PlateauCommand $command
     */
    public function __construct(private PlateauCommand $command)
    {
    }

    /**
     * @return Plateau
     */
    public function getPlateau(): Plateau
    {
        return new Plateau($this->command->getX(), $this->command->getY());
    }
}
