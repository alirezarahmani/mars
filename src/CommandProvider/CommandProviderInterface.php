<?php

declare(strict_types=1);

namespace MarsRover\CommandProvider;

use MarsRover\Command\CommandInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface CommandProviderInterface
{
    public function validate(array $data): ConstraintViolationListInterface;

    public function getCommand(array $data): CommandInterface;
}
