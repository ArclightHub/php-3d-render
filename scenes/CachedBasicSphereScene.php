<?php

namespace scenes;

use objects\cartesian\Location;
use objects\cartesian\Rotation;
use objects\primitives\Sphere;

/**
 * Similar to BasicSphereScene except that it caches the Sphere object and points.
 *
 * SOLID:
 *
 * Single Responsibility:
 * - Creates a sphere object and reuses it when already configured once.
 *
 * Liskov Substitution Principle
 * - The engine does not care which scene is loaded, the scenes implementation can change without the engine needing to know.
 *
 * Dependency Inversion Principle
 * - The object has no knowledge of how it will be used.
 *
 * Class CachedBasicSphereScene
 * @package scenes
 */
class CachedBasicSphereScene extends Scene
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
        $size = 4,
        $x = 0,
        $y = 0,
        $z = 0,
        $rotX = 0,
        $rotY = 0,
        $rotZ = 0
    ) {
        if (is_null($size)) {
            $size = 13;
        }
        $location = new Location($x + 24,$y + 24, $z);
        $rotation = new Rotation($rotX, $rotY + 90, $rotZ);
        if (!is_null(self::$cache)) {
            $shape = self::$cache;
            $shape->setRotation($rotation);
            $shape->setLocation($location);
        } else {
            $shape = new Sphere($location, $rotation, $size);
            self::$cache = $shape;
        }
        $this->addObjectToScene($shape);
    }
}