<?php

namespace objects\primitives;

use objects\cartesian\Location;
use objects\cartesian\Point;
use objects\cartesian\Rotation;

/**
 * Lines along each axis, makes it easier to understand the rotation.
 *
 * Class Needle
 * @package objects\primitives
 */
class Needle extends AbstractPrimitive implements PolygonInterface
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

        $this->generateMesh();
    }

    /**
     * @return array
     */
    private function generatePoints($size)
    {
        $points = [];
        $points[] = new Point(0, 0, 0);
        for ($i = 0; $i <= 4; $i+=4) {
            $points[] = new Point($i, 0, 0);
            $points[] = new Point(0, $i, 0);
            $points[] = new Point(0, 0, $i);
        }
        return $points;
    }
}