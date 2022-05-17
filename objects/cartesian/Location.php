<?php

namespace objects\cartesian;

/**
 * The Location defined a 3 dimensional point in space.
 *
 * SOLID:
 *
 * Single Responsibility:
 * - Encapsulates a location in an anemic class.
 *
 * Open-closed Principle
 * - It can be used as part of a bigger point or polygon.
 *
 * Dependency Inversion Principle
 * - The object has no knowledge of how it will be used.
 *
 * Class Location
 * @package objects\cartesian
 */
class Location
{
    /** @var int|float */
    protected $x;

    /** @var int|float */
    protected $y;

    /** @var int|float */
    protected $z;

    /**
     * @param int|float $x
     * @param int|float $y
     * @param int|float $z
     */
    public function __construct($x, $y, $z)
    {
        $this->x = number_format($x, 2);
        $this->y = number_format($y, 2);
        $this->z = number_format($z, 2);
    }

    /**
     * @return float|int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param mixed $x
     */
    public function setX($x): void
    {
        $this->x = $x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param mixed $y
     */
    public function setY($y): void
    {
        $this->y = $y;
    }

    /**
     * @return mixed
     */
    public function getZ()
    {
        return $this->z;
    }

    /**
     * @param mixed $z
     */
    public function setZ($z): void
    {
        $this->z = $z;
    }
}