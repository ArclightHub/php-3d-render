<?php

namespace objects\primitives;

use objects\cartesian\Location;
use objects\cartesian\Point;
use objects\cartesian\Rotation;

/**
 * SOLID:
 *
 * Single Responsibility:
 * - Encapsulates all the logic required to generate a mesh of points in the shape of a cube.
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
 * Class Cube
 * @package objects\primitives
 */
class Cube extends AbstractPrimitive implements PolygonInterface
{
    use GenerateMeshTrait;

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

        // Verify the state of the cube
        foreach ($this->getPoints() as $point) {
            if (!count($point->getLines()) == 3) {
                // Each point in a cube should connect to 3 others
                $message = sprintf("Got %d, expected 3.", count($point->getLines()));
                throw new \Exception($message);
            }
        }
    }

    /**
     * @return array
     */
    private function generatePoints($size)
    {
        $points = [];
        $identities = [1, -1];
        foreach ($identities as $xIdentity) {
            foreach ($identities as $yIdentity) {
                foreach ($identities as $zIdentity) {
                    $points[] = new Point(
                        $xIdentity * $size,
                        $yIdentity * $size,
                        $zIdentity * $size
                    );
                }
            }
        }
        return $points;
    }
}