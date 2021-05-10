<?php

declare(strict_types=1);

namespace MarsRover\ValueObject;

use MarsRover\Exceptions\InvalidMoveException;

/**
 * Class RoverMove
 * in php 8.1 we can define enum, but here I use 8.0
 * @package MarsRover\ValueObject
 */
class RoverMove
{
    public const L = 'L';
    public const R = 'R';
    public const M = 'M';

    public function __construct(private string $value)
    {
        if (!in_array($value, [self::M, self::M, self::L, self::R])) {
            throw new InvalidMoveException($value . ' not found');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
