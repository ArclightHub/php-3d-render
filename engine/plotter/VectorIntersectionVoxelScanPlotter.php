<?php

namespace engine\plotter;

use engine\transforms\AffineTransform;
use engine\transforms\ObjectRelativeTransform;
use objects\cartesian\Point;
use objects\interfaces\PolygonInterface;
use objects\primitives\Primitive;

class VectorIntersectionVoxelScanPlotter implements PlotterInterface, VoxelScanPlotterInterface
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
                $relPointConnection = $relativeTransform->transform($this->sceneObject, $relPointConnection);
                if ($x == $relPoint->getX()
                    && $y == $relPoint->getY()
                    && $z == $relPoint->getZ()
                ) {
                    return -1;
                }
                if (
                    $this->isThePointBetweenTheTwoOnTheGivenAxis($z, $relPoint->getZ(), $relPointConnection->getZ())
                    && $this->isThePointBetweenTheTwoOnTheGivenAxis($x, $relPoint->getX(), $relPointConnection->getX())
                    && $this->isThePointBetweenTheTwoOnTheGivenAxis($y, $relPoint->getY(), $relPointConnection->getY())
                ) {
                    return 1;
                }
            }
        }
        return false;
    }

    /**
     * @param $pointToCheck
     * @param $point1
     * @param $point2
     * @return bool
     */
    private function isThePointBetweenTheTwoOnTheGivenAxis($pointToCheck, $point1, $point2)
    {
        // The line falls between the two points on the axis
        if (($pointToCheck < $point1 && $pointToCheck > $point2) ||
            ($pointToCheck < $point2 && $pointToCheck > $point1)) {
            return true;
        }
        // If the two points are very close together on the same axis
        // We should plot them with additional precision
        if (abs($point1 - $point2) <= 1) {
            if (
                ($pointToCheck <= $point1 && $pointToCheck >= $point2) ||
                ($pointToCheck <= $point2 && $pointToCheck >= $point1)
            ) {
                return true;
            }
        }
        return false;
    }
}