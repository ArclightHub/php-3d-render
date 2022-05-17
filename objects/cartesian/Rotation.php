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
    private $xRotation;
    private $yRotation;
    private $zRotation;

    /**
     * @param int $xRotation
     * @param int $yRotation
     * @param int $zRotation
     */
    public function __construct($xRotation = 0, $yRotation = 0, $zRotation = 0)
    {
        $this->xRotation = $xRotation;
        $this->yRotation = $yRotation;
        $this->zRotation = $zRotation;
    }

    /**
     * @return mixed
     */
    public function getXRotation()
    {
        return $this->xRotation;
    }

    /**
     * @return mixed
     */
    public function getYRotation()
    {
        return $this->yRotation;
    }

    /**
     * @return mixed
     */
    public function getZRotation()
    {
        return $this->zRotation;
    }
}