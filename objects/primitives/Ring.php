<?php

namespace objects\primitives;

use objects\cartesian\Location;
use objects\cartesian\Point;
use objects\cartesian\Rotation;
use objects\interfaces\PolygonInterface;

class Ring extends Primitive implements PolygonInterface
{
    /**
     * @param Location $location
     * @param Rotation $rotation
     * @param int $size
     */
    public function __construct(
        Location $location,
        Rotation $rotation,
        $size = 3
    ) {
        // $location will define the centre of the cube
        $this->setLocation($location);

        // Set the rotation around the centre
        $this->setRotation($rotation);

        // Since a cube has regular sides, we should calculate all its points from there
        $this->setPoints($this->generatePoints($size));

        // Now calculate the lines from the points.
        $this->generateMesh();
    }

    /**
     * @return array
     */
    private function generatePoints($size)
    {
        $size = $size * (1/sqrt(2));
        $points = [];
        $degreeIncrements = 45;
        for ($deg = 0; $deg < 360; $deg += $degreeIncrements) {
            $x = $this->rotateX($size, $size, $deg);
            $y = $this->rotateY($size, $size, $deg);
            $points[] = new Point(
                $x,
                $y,
                $size
            );
        }
        return $points;
    }

    private function rotateX($x, $y, $rotation)
    {
        $radians = (pi() / 180 * $rotation);
        return $x * cos($radians) - $y * sin($radians);
    }

    private function rotateY($x, $y, $rotation)
    {
        $radians = (pi() / 180 * $rotation);
        return $x * sin($radians) + $y * cos($radians);
    }
}