<?php

namespace MarsRover\Tests;

use MarsRover\Domain\MarsRover;
use MarsRover\Domain\Plateau;
use MarsRover\Exceptions\InvalidMoveException;
use MarsRover\Exceptions\PositionNotOnPlateauException;
use MarsRover\ValueObject\Direction;
use MarsRover\ValueObject\Position;
use MarsRover\ValueObject\RoverMove;
use PHPUnit\Framework\TestCase;

/**
 * Class MarsRoverTest
 * @package MarsRover\Tests
 */
class MarsRoverTest extends TestCase
{
    /**
     * @var Plateau
     */
    private Plateau $plateau;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resetPlateau();
    }

    /** @test */
    public function moving_rover_should_succeed()
    {
        // arrange
        $rover = new MarsRover(new Position(1, 2), new Direction('N'), $this->plateau);

        // action
        $rover->move(new RoverMove('L'));
        $rover->move(new RoverMove('M'));
        $rover->move(new RoverMove('L'));
        $rover->move(new RoverMove('M'));
        $rover->move(new RoverMove('L'));
        $rover->move(new RoverMove('M'));
        $rover->move(new RoverMove('L'));
        $rover->move(new RoverMove('M'));
        $rover->move(new RoverMove('M'));

        // assert
        $this->assertEquals($rover->reportPosition(), "1 3 N");
    }

    /** @test */
    public function moving_rover_two_should_succeed()
    {
        // arrange
        $rover = new MarsRover(new Position(3, 3), new Direction('E'), $this->plateau);

        // action
        $rover->move(new RoverMove('M'));
        $rover->move(new RoverMove('M'));
        $rover->move(new RoverMove('R'));
        $rover->move(new RoverMove('M'));
        $rover->move(new RoverMove('M'));
        $rover->move(new RoverMove('R'));
        $rover->move(new RoverMove('M'));
        $rover->move(new RoverMove('R'));
        $rover->move(new RoverMove('R'));
        $rover->move(new RoverMove('M'));

        // assert
        $this->assertEquals($rover->reportPosition(), "5 1 E");
    }

    /** @test */
    public function moving_rover_beyond_plateau_should_throw()
    {
        try {
            // arrange
            $rover = new MarsRover(new Position(3, 6), new Direction('E'), $this->plateau);
            // action
            $rover->move(new RoverMove('M'));
            $this->assertTrue('should not reach here', false);
        } catch (PositionNotOnPlateauException $ex) {
            // assert
            $this->assertEquals('Position not on plateau', $ex->getMessage());
        }
    }

    /** @test  */
    public function unknown_move_direction_should_throw() {
        try {
            // arrange
            new MarsRover(new Position(3, 5), new Direction('G'), $this->plateau);
            $this->assertTrue('should not reach here', false);
        } catch (InvalidMoveException $ex) {
            // assert
            $this->assertEquals('G not found', $ex->getMessage());
        }
    }

    /** @test  */
    public function moving_rover_over_another_rover_should_throw() {
        // arrange
        $this->resetPlateau();
        new MarsRover(new Position(3, 5), new Direction('N'), $this->plateau);
        try {
            new MarsRover(new Position(3, 5), new Direction('E'), $this->plateau);
            $this->assertTrue('should not reach here', false);
        } catch (\RuntimeException $ex) {
            // assert
            $this->assertEquals('Already occupied by a rover!', $ex->getMessage());
        }
    }

    /** @test  */
    public function dropping_two_rovers_next_to_another_should_succeed() {
        // arrange
        $this->resetPlateau();
        new MarsRover(new Position(3, 4), new Direction('N'), $this->plateau);
        new MarsRover(new Position(3, 5), new Direction('N'), $this->plateau);
        $this->assertTrue(true);
    }

    private function resetPlateau()
    {
        $this->plateau = new Plateau(5, 5);
    }
}
