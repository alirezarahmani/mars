<?php

declare(strict_types=1);

namespace MarsRover\Factory;

use MarsRover\InputRequest\PlateauInputRequest;
use MarsRover\Domain\Plateau;

/**
 * Class PlateauFactory
 * @package MarsRover\Handler
 */
class PlateauFactory
{
    /**
     * PlateauFactory constructor.
     * @param PlateauInputRequest $input
     */
    public function __construct(private PlateauInputRequest $input)
    {
    }

    /**
     * @return Plateau
     */
    public function getPlateau(): Plateau
    {
        return new Plateau($this->input->getX(), $this->input->getY());
    }
}
