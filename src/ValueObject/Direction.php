<?php

declare(strict_types=1);

namespace MarsRover\ValueObject;

use MarsRover\Exceptions\InvalidMoveException;

/**
 * Class Direction
 * in php 8.1 we can define enum, but here I use 8.0
 * @package MarsRover\ValueObject
 */
class Direction
{
    const N = 'N';
    const E = 'E';
    const W = 'W';
    const S = 'S';

    /**
     * Direction constructor.
     * @param string $value
     */
    public function __construct(private string $value)
    {
        if (!in_array($value, [self::N, self::E, self::W, self::S])) {
            throw new InvalidMoveException($value . ' not found');
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

}
