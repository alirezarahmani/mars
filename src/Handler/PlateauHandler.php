<?php

declare(strict_types=1);

namespace MarsRover\Handler;

use MarsRover\Command\PlateauCommand;
use MarsRover\Domain\MarsRover;
use MarsRover\Domain\Plateau;

class PlateauHandler
{
    private MarsRover $marsRover;

    public function __construct(private PlateauCommand $command)
    {}

    public function getPlateau(): Plateau
    {
        return new Plateau($this->command->getX(), $this->command->getY());
    }
}
