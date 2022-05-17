<?php

namespace scenes;

use objects\cartesian\Location;
use objects\cartesian\Rotation;
use objects\primitives\Hyperboloid;

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
 * Class BasicHyperboloidScene
 * @package scenes
 */
class BasicHyperboloidScene extends Scene
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
        $size = 7,
        $x = 0,
        $y = 0,
        $z = 0,
        $rotX = 0,
        $rotY = 0,
        $rotZ = 0
    ) {
        if (is_null($size)) {
            $size = 12;
        }
        $cubeLocation = new Location($x + 24,$y + 24, $z);
        $cubeRotation = new Rotation($rotX + 22.5, $rotY + 22.5, $rotZ);
        $cube = new Hyperboloid($cubeLocation, $cubeRotation, $size);
        $this->addObjectToScene($cube);
    }
}