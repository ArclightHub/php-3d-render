<?php

namespace scenes;

use objects\cartesian\Location;
use objects\cartesian\Rotation;
use objects\primitives\Cylinder;

/**
 * SOLID:
 *
 * Single Responsibility:
 * - Creates scene which is comprised of various primitives.
 *
 * Liskov Substitution Principle
 * - The engine does not care which scene is loaded, the scenes implementation can change without the engine needing to know.
 *
 * Dependency Inversion Principle
 * - The object has no knowledge of how it will be used.
 *
 * Class BasicCylinderScene
 * @package scenes
 */
class BasicCylinderScene extends Scene
{
    /**
     * @param null|null $size
     * @param int $x
     * @param int $y
     * @param int $z
     * @param int $rotX
     * @param int $rotY
     * @param int $rotZ
     */
    public function __construct(
        $size = 4,
        $x = 0,
        $y = 0,
        $z = 0,
        $rotX = 0,
        $rotY = 0,
        $rotZ = 0
    ) {
        if (is_null($size)) {
            $size = 15;
        }
        $location = new Location($x + 24,$y + 24, $z);
        $rotation = new Rotation($rotX, $rotY, $rotZ);
        $shape = new Cylinder($location, $rotation, $size);
        $this->addObjectToScene($shape);
    }
}