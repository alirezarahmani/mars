<?php

declare(strict_types=1);

namespace MarsRover\Factory;

use MarsRover\InputRequest\MarsRoverInputRequest;
use MarsRover\Domain\MarsRover;
use MarsRover\ValueObject\RoverMove;

/**
 * Class MarsRoverHandler
 * @package MarsRover\Handler
 */
class MarsRoverFactory
{
    /**
     * @var MarsRover
     */
    private MarsRover $marsRover;

    /**
     * MarsRoverHandler constructor.
     * @param MarsRoverInputRequest $input
     */
    public function __construct(private MarsRoverInputRequest $input)
    {
        $this->marsRover = new MarsRover(
            $this->input->getPosition(),
            $this->input->getRoverDirection(),
            $this->input->getPlateau()
        );
        $moves = $this->input->getMoves();
        /** @var RoverMove $move */
        foreach ($moves as $move) {
            $this->marsRover->move($move);
        }
    }

    /**
     * @return string
     */
    public function reportPosition(): string
    {
        return $this->marsRover->reportPosition();
    }
}
