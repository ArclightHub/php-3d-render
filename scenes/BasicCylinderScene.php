<?php

namespace scenes;

use objects\cartesian\Location;
use objects\cartesian\Rotation;
use objects\primitives\Cylinder;

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
            $size = 4;
        }
        $location = new Location($x + 16,$y + 16, $z);
        $rotation = new Rotation($rotX, $rotY, $rotZ);
        $shape = new Cylinder($location, $rotation, $size);
        $this->addObjectToScene($shape);
    }
}