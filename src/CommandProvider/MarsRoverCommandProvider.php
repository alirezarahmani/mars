<?php

declare(strict_types=1);

namespace MarsRover\CommandProvider;

use MarsRover\Command\CommandInterface;
use MarsRover\Command\MarsRoverCommand;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class MarsRoverCommandProvider implements CommandProviderInterface
{
    /**
     * MarsRoverCommandProvider constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(private ValidatorInterface $validator)
    {}

    /**
     * @param array $data
     * @return ConstraintViolationListInterface
     */
    public function validate(array $data): ConstraintViolationListInterface
    {
        return $this->validator->validate($data);
    }

    /**
     * @param array $data
     * @return CommandInterface
     */
    public function getCommand(array $data): CommandInterface
    {
        return new MarsRoverCommand(...$data);
    }
}
