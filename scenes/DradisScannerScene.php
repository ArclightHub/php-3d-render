<?php

namespace scenes;

use objects\cartesian\Location;
use objects\cartesian\Rotation;
use objects\primitives\Ring;

/**
 * TODO: We can use the sphere instead of rings and it would actually be a 3d dradis.
 *
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
 * Class DradisScannerScene
 * @package scenes
 */
class DradisScannerScene extends Scene
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
        // Rings
        for ($i = 4; $i < 32; $i+= 5) {
            $z = 0;
            $location = new Location($x + 48,$y + 24, $z-5);
            $rotation = new Rotation(0, 0, 0);
            $shape = new Ring($location, $rotation, $i);
            $this->addObjectToScene($shape);
        }
        // Scanner Wave Thingy
        $z = 0;
        $location = new Location($x + 48,$y + 24, $z);
        $rotation = new Rotation(75, $rotY*3, 75);
        $shape = new Ring($location, $rotation, 32);
        $this->addObjectToScene($shape);
    }
}