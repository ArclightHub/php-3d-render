<?php

namespace objects\cartesian;

/**
 * Rotation is defined as degrees around a given axis.
 *
 * SOLID:
 *
 * Single Responsibility:
 * - Encapsulates all the logic required to get the rotation of an object.
 *
 * Dependency Inversion Principle
 * - The object has no knowledge of how it will be used.
 *
 * Class Rotation
 * @package objects\cartesian
 */
class Rotation
{
    /** @var int|float */
    private $xRotation;

    /** @var int|float */
    private $yRotation;

    /** @var int|float */
    private $zRotation;

    /**
     * Rotation constructor.
     * @param int|float $xRotation
     * @param int|float $yRotation
     * @param int|float $zRotation
     */
    public function __construct($xRotation = 0, $yRotation = 0, $zRotation = 0)
    {
        $this->xRotation = $xRotation;
        $this->yRotation = $yRotation;
        $this->zRotation = $zRotation;
    }

    /**
     * @return float|int
     */
    public function getXRotation()
    {
        return $this->xRotation;
    }

    /**
     * @return float|int
     */
    public function getYRotation()
    {
        return $this->yRotation;
    }

    /**
     * @return float|int
     */
    public function getZRotation()
    {
        return $this->zRotation;
    }
}