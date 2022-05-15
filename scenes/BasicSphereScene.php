<?php

namespace scenes;

use objects\cartesian\Location;
use objects\cartesian\Rotation;
use objects\primitives\Sphere;

class BasicSphereScene extends Scene
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
            $size = 9;
        }
        $location = new Location($x + 16,$y + 16, $z);
        $rotation = new Rotation($rotX, $rotY + 90, $rotZ);
        $shape = new Sphere($location, $rotation, $size);
        $this->addObjectToScene($shape);
    }
}