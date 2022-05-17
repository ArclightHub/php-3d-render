<?php

namespace scenes;

use objects\cartesian\Location;
use objects\cartesian\Rotation;
use objects\primitives\Cube;

/**
 * Similar to BasicCubeScene except that it caches the object and points.
 *
 * SOLID:
 *
 * Single Responsibility:
 * - Creates a cube object and reuses it when already configured once.
 *
 * Liskov Substitution Principle
 * - The engine does not care which scene is loaded, the scenes implementation can change without the engine needing to know.
 *
 * Dependency Inversion Principle
 * - The object has no knowledge of how it will be used.
 *
 * Class CachedBasicCubeScene
 * @package scenes
 */
class CachedBasicCubeScene extends Scene
{
    private static $cache = null;

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
        $cubeRotation = new Rotation($rotX + 22.5, $rotY + 22.5, $rotZ);
        $cubeLocation = new Location($x + 24,$y + 24,$z);
        if (!is_null(self::$cache)) {
            $cube = self::$cache;
            $cube->setRotation($cubeRotation);
            $cube->setLocation($cubeLocation);
        } else {
            $cube = new Cube($cubeLocation, $cubeRotation, $size);
        }
        $this->addObjectToScene($cube);
        self::$cache = $cube;
        // Add needle
        //$cube = new Needle(
        //    new Location($x + 43, $y + 3, $z),
        //    new Rotation($rotX + 22.5, $rotY + 22.5, $rotZ),
        //    $size
        //);
        //$this->addObjectToScene($cube);
    }
}