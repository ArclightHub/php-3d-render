<?php

namespace objects\primitives;

use objects\cartesian\Location;
use objects\cartesian\Point;
use objects\cartesian\Rotation;
use traits\RotatableTrait;

/**
 * SOLID:
 *
 * Single Responsibility:
 * - Encapsulates all the logic required to generate a mesh of points in the shape of a ring.
 *
 * Open-closed Principle
 * - It can be used as part of a bigger polygon or its lines can be moved to form a different shape.
 *
 * Liskov Substitution Principle
 * - It is a shape which implements the PolygonInterface interface, can be used in any code which uses a polygon.
 *
 * Dependency Inversion Principle
 * - The object has no knowledge of how it will be used.
 *
 * Class Ring
 * @package objects\primitives
 */
class Ring extends AbstractPrimitive implements PolygonInterface
{
    use GenerateMeshTrait;
    use RotatableTrait;

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
        $this->generateMeshForClosestPoints($this);
    }

    /**
     * @return array
     */
    private function generatePoints($size)
    {
        $size = $size * (1/sqrt(2));
        $points = [];
        $degreeIncrements = 30;
        for ($deg = 0; $deg < 360; $deg += $degreeIncrements) {
            $x = $this->rotateX($size, $size, $deg);
            $y = $this->rotateY($size, $size, $deg);
            $points[] = new Point(
                $x,
                $y,
                0
            );
        }
        return $points;
    }
}