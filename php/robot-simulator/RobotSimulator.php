<?php

declare(strict_types=1);

class Robot
{
    const DIRECTION_NORTH = 'north';
    const DIRECTION_SOUTH = 'south';
    const DIRECTION_EAST = 'east';
    const DIRECTION_WEST = 'west';

    /**
     *
     * @var int[]
     */
    protected $position;

    /**
     *
     * @var string
     */
    protected $direction;

    public function __construct(array $position, string $direction)
    {
        $this->position = $position;
        $this->direction = $direction;
    }

    function __get(string $name)
    {
        return $this->{$name} ?? null;
    }

    protected function changeDirection(string $turn_direction) :void
    {
        // around? back?
        $points = [ 'right' => '', 'left' => '' ];

        if ( !array_key_exists($turn_direction, $points) ) {
            throw new \InvalidArgumentException("Only right or left");
        }

        switch ($this->direction) {
            case self::DIRECTION_NORTH: {
                $points['right'] = self::DIRECTION_EAST;
                $points['left'] = self::DIRECTION_WEST;
                break;
            }

            case self::DIRECTION_EAST: {
                $points['right'] = self::DIRECTION_SOUTH;
                $points['left'] = self::DIRECTION_NORTH;
                break;
            }

            case self::DIRECTION_SOUTH: {
                $points['right'] = self::DIRECTION_WEST;
                $points['left'] = self::DIRECTION_EAST;
                break;
            }

            case self::DIRECTION_WEST: {
                $points['right'] = self::DIRECTION_NORTH;
                $points['left'] = self::DIRECTION_SOUTH;
                break;
            }

            default: break;
        }

        $this->direction = $points[ $turn_direction ] ?? $this->direction;
    }

    public function turnRight(): self
    {
        $this->changeDirection('right');

        return $this;
    }

    public function turnLeft(): self
    {
        $this->changeDirection('left');

        return $this;
    }

    public function advance(): self
    {
        switch ($this->direction) {
            case self::DIRECTION_NORTH: {
                $this->position[1]++;
                break;
            }

            case self::DIRECTION_EAST: {
                $this->position[0]++;
                break;
            }

            case self::DIRECTION_SOUTH: {
                $this->position[1]--;
                break;
            }

            case self::DIRECTION_WEST: {
                $this->position[0]--;
                break;
            }

            default: break;
        }

        return $this;
    }

    public function instructions(string $instructions) :self
    {
        $instructions = strtoupper($instructions);

        if ( !$instructions || preg_match('/[^RLA]/', $instructions) ) {
            throw new \InvalidArgumentException('Instruction error');
        }

        for ($i=0; $i <= (strlen($instructions) - 1); $i++) 
        {
            switch ( $instructions[$i] ) {
                case 'R': {
                    $this->turnRight();
                    break;
                }

                case 'L': {
                    $this->turnLeft();
                    break;
                }

                case 'A': {
                    $this->advance();
                    break;
                }

                default: break;
            }
        }

        return $this;
    }
}
