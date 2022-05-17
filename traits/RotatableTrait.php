<?php

namespace traits;

/**
 * Trait to allow x and y coordinates to be rotated
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