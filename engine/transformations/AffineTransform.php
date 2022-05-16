<?php

namespace engine\transforms;

use objects\cartesian\Point;
use objects\cartesian\Rotation;
use objects\interfaces\PolygonInterface;

/**
 * $point1x = $point->getX() * cos($xRadians) - $point->getY() * sin($xRadians);
 * $point1y = $point->getX() * sin($xRadians) + $point->getY() * cos($xRadians);
 */
class AffineTransform
{
    /**
     * @param PolygonInterface $object
     * @param Point $point
     * @return Point
     */
    public function transform($object, $point)
    {
        /** @var Rotation $objectRotation */
        $objectRotation = $object->getRotation();

        // Rotate around the Z axis
        $rotX = round($this->rotateX($point->getX(), $point->getY(), $objectRotation->getZRotation()));
        $rotY = round($this->rotateY($point->getX(), $point->getY(), $objectRotation->getZRotation()));
        $rotated = new Point($rotX, $rotY, $point->getZ());
        $rotated->setLines($point->getLines());

        // Rotate around the Y axis
        $rotZ = round($this->rotateX($rotated->getZ(), $rotated->getX(), $objectRotation->getYRotation()));
        $rotX = round($this->rotateY($rotated->getZ(), $rotated->getX(), $objectRotation->getYRotation()));
        $rotated->setZ($rotZ);
        $rotated->setX($rotX);

        // Rotate around the X axis
        $rotY = round($this->rotateX($rotated->getY(), $rotated->getZ(), $objectRotation->getXRotation()));
        $rotZ = round($this->rotateY($rotated->getY(), $rotated->getZ(), $objectRotation->getXRotation()));
        $rotated->setY($rotY);
        $rotated->setZ($rotZ);

        return $rotated;
    }

    private function rotateX($x, $y, $rotation)
    {
        $radians = (pi() / 180 * $rotation);
        return $x * cos($radians) - $y * sin($radians);
    }

    private function rotateY($x, $y, $rotation)
    {
        $radians = (pi() / 180 * $rotation);
        return $x * sin($radians) + $y * cos($radians);
    }
}