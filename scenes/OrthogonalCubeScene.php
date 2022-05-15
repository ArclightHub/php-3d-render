<?php

namespace scenes;

use objects\cartesian\Location;
use objects\cartesian\Rotation;
use objects\primitives\Cube;

class OrthogonalCubeScene extends Scene
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
        // Top Left Cube
        $cubeLocation = new Location($x + 8, $y + 8, $z);
        $cubeRotation = new Rotation($rotX, $rotY, $rotZ);
        $cube = new Cube($cubeLocation, $cubeRotation, $size);
        $this->addObjectToScene($cube);
        // Bottom Left Cube
        $cubeLocation = new Location($x + 24, $y + 8, $z);
        $cubeRotation = new Rotation($rotX, $rotY, $rotZ + 45);
        $cube = new Cube($cubeLocation, $cubeRotation, $size);
        $this->addObjectToScene($cube);
        // Top Right Cube
        $cubeLocation = new Location($x + 8, $y + 24, $z);
        $cubeRotation = new Rotation($rotX, $rotY + 22.5, $rotZ);
        $cube = new Cube($cubeLocation, $cubeRotation, $size);
        $this->addObjectToScene($cube);
        // Bottom Right Cube
        $cubeLocation = new Location($x + 24, $y + 24, $z);
        $cubeRotation = new Rotation($rotX + 22.5, $rotY + 22.5, $rotZ);
        $cube = new Cube($cubeLocation, $cubeRotation, $size);
        $this->addObjectToScene($cube);
    }
}