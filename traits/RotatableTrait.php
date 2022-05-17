<?php

namespace traits;

/**
 * Trait to allow x and y coordinates to be rotated
 *
 * SOLID:
 *
 * Single Responsibility:
 * - Encapsulates all the logic required to perform a rotation for an X and Y coordinate around a Rotation axis.
 *
 * Open-closed Principle
 * - It can be used around different axes and object types which have xy pairs that need to be rotated.
 *
 * Dependency Inversion Principle
 * - The object has no knowledge of how it will be used, only that it rotates X and Y around Rotation
 *
 * Trait RotatableTrait
 * @package traits
 */
trait RotatableTrait
{
    /**
     * @param int|float $x
     * @param int|float $y
     * @param int|float $rotation
     * @return float|int
     */
    public function rotateX($x, $y, $rotation)
    {
        $radians = deg2rad($rotation);
        return $x * cos($radians) - $y * sin($radians);
    }

    /**
     * @param int|float $x
     * @param int|float $y
     * @param int|float $rotation
     * @return float|int
     */
    public function rotateY($x, $y, $rotation)
    {
        $radians = deg2rad($rotation);
        return $x * sin($radians) + $y * cos($radians);
    }
}