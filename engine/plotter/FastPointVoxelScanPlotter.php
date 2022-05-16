<?php

namespace engine\plotter;

use engine\transforms\AffineTransform;
use engine\transforms\ObjectRelativeTransform;
use objects\cartesian\Point;
use objects\interfaces\PolygonInterface;
use objects\primitives\Primitive;

/**
 * Only plots points.
 */
class FastPointVoxelScanPlotter implements VoxelScanPlotterInterface
{
    /** @var PolygonInterface|Primitive */
    private $sceneObject;

    /**
     * @param $sceneObject
     */
    public function __construct($sceneObject)
    {
        $this->sceneObject = $sceneObject;
    }

    public function plot($x, $y, $z)
    {
        /** @var Point $point */
        foreach ($this->sceneObject->getPoints() as $point) {
            /** @var Point $pointConnection */
            foreach ($point->getLines() as $pointConnection) {
                // Rotate the points around the object centre
                $affineTransform = new AffineTransform();
                $relPoint = $affineTransform->transform($this->sceneObject, $point);
                $relPointConnection = $affineTransform->transform($this->sceneObject, $pointConnection);

                // Translate the points in space relative to the centre of the object
                $relativeTransform = new ObjectRelativeTransform();
                $relPoint = $relativeTransform->transform($this->sceneObject, $relPoint);
                if ($x == $relPoint->getX()
                    && $y == $relPoint->getY()
                    && $z == $relPoint->getZ()
                ) {
                    return -1;
                }
            }
        }
        return false;
    }
}