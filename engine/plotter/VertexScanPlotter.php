<?php

namespace engine\plotter;

use engine\transforms\AffineTransform;
use engine\transforms\ObjectRelativeTransform;
use objects\cartesian\Point;
use objects\primitives\PolygonInterface;
use objects\primitives\AbstractPrimitive;

/**
 * Scans the vectors of all connected points and plots their XY coordinates into the output buffer.
 *
 * SOLID:
 *
 * Single Responsibility:
 * - Plots vectors into the output buffer
 *
 * Liskov Substitution Principle
 * - Implements the PlotterInterface and VertexScanPlotterInterface interface, can be used in any code which uses a them.
 *
 * Interface Segregation Principle:
 * - Uses PlotterInterface and VertexScanPlotterInterface interfaces which change the way plot() is called.
 *
 * Dependency Inversion Principle
 * - The higher level RenderEngine does not need to know how the plotting was done
 *
 * Class VertexScanPlotter
 * @package engine\plotter
 */
class VertexScanPlotter implements PlotterInterface, VertexScanPlotterInterface
{
    /** @var PolygonInterface|AbstractPrimitive */
    private $sceneObject;

    /**
     * @param $sceneObject
     */
    public function __construct($sceneObject)
    {
        $this->sceneObject = $sceneObject;
    }

    public function plot(&$outputBuffer)
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

                // Add the points
                $x = $relPoint->getX();
                $y = $relPoint->getY();
                if (!isset($outputBuffer[$x][$y])) {
                    $outputBuffer[$x][$y] = 0;
                }
                $outputBuffer[$x][$y] = 'solid';

                // Travel the vectors
                $length = $this->getVectorLength($relPoint, $relPointConnection);
                if ($length == 0) {
                    $length = 1;
                }
                $xSign = $relPoint->getX() < $relPointConnection->getX() ? 1 : -1;
                $ySign = $relPoint->getY() < $relPointConnection->getY() ? 1 : -1;
                //$zSign = $relPoint->getZ() < $relPointConnection->getZ() ? 1 : -1;
                $xSeg = abs($relPoint->getX() - $relPointConnection->getX())*$xSign/$length;
                $ySeg = abs($relPoint->getY() - $relPointConnection->getY())*$ySign/$length;
                //$zSeg = abs($relPoint->getZ() - $relPointConnection->getZ())*$zSign/$length;
                for ($i = 0; $i <= $length; $i++) {
                    $x = round($relPoint->getX() + ($xSeg * $i));
                    $y = round($relPoint->getY() + ($ySeg * $i));
                    if (!isset($outputBuffer[$x][$y])) {
                        $outputBuffer[$x][$y] = 0;
                    }
                    if ($outputBuffer[$x][$y] === 'solid') {
                        continue;
                    }
                    $outputBuffer[$x][$y]++;
                }
            }
        }
    }

    private function getVectorLength(Point $point1, Point $point2)
    {
        $x = abs($point1->getX() - $point2->getX());
        $y = abs($point1->getY() - $point2->getY());
        $z = abs($point1->getZ() - $point2->getZ());
        return sqrt(
            pow($x, 2) +
            pow($y, 2) +
            pow($z, 2)
        );
    }
}