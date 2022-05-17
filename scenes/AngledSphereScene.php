<?php

namespace scenes;

use objects\cartesian\Location;
use objects\cartesian\Rotation;
use objects\primitives\Sphere;

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
 * Class AngledSphereScene
 * @package scenes
 */
class AngledSphereScene extends Scene
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
            $size = 7;
        }
        // Top Left Cube
        $cubeLocation = new Location($x + 12,$y + 12,$z);
        $cubeRotation = new Rotation($rotX, $rotY, $rotZ);
        $cube = new Sphere($cubeLocation, $cubeRotation, $size);
        $this->addObjectToScene($cube);
        // Bottom Left Cube
        $cubeLocation = new Location($x + 36, $y + 12, $z);
        $cubeRotation = new Rotation($rotX + 45, $rotY + 45, $rotZ);
        $cube = new Sphere($cubeLocation, $cubeRotation, $size);
        $this->addObjectToScene($cube);
        // Top Right Cube
        $cubeLocation = new Location($x + 12, $y + 36, $z);
        $cubeRotation = new Rotation($rotX, $rotY + 45, $rotZ);
        $cube = new Sphere($cubeLocation, $cubeRotation, $size);
        $this->addObjectToScene($cube);
        // Bottom Right Cube
        $cubeLocation = new Location($x + 36, $y + 36, $z);
        $cubeRotation = new Rotation($rotX + 22.5, $rotY + 22.5, $rotZ);
        $cube = new Sphere($cubeLocation, $cubeRotation, $size);
        $this->addObjectToScene($cube);
    }
}