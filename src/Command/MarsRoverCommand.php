<?php

declare(strict_types=1);

namespace MarsRover\Command;

use MarsRover\Domain\Plateau;
use MarsRover\ValueObject\Direction;
use MarsRover\ValueObject\Position;
use MarsRover\ValueObject\RoverMove;

/**
 * Class MarsRoverCommand
 * @package MarsRover\Command
 */
class MarsRoverCommand implements CommandInterface
{
    /**
     * @var array
     */
    private array $roverMoves;

    /**
     * MarsRoverCommand constructor.
     * @param int $x
     * @param int $y
     * @param string $direction
     * @param string $moves
     * @param Plateau $plateau
     */
    public function __construct(
        private int $x,
        private int $y,
        private string $direction,
        private string $moves,
        private Plateau $plateau
    ) {
    }

    /**
     * @return Direction
     */
    public function getRoverDirection(): Direction
    {
        return new Direction($this->direction);
    }

    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return new Position($this->x, $this->y);
    }

    /**
     * @return array
     */
    public function getMoves(): array
    {
        $allMoves = str_split($this->moves);
        foreach ($allMoves as $move) {
            $this->roverMoves[] = new RoverMove($move);
        }
        return $this->roverMoves;
    }

    /**
     * @return Plateau
     */
    public function getPlateau(): Plateau
    {
        return $this->plateau;
    }
}
