<?php

namespace objects\primitives;

use objects\cartesian\Location;
use objects\cartesian\Point;
use objects\cartesian\Rotation;

class Sphere extends AbstractPrimitive implements PolygonInterface
{
    /**
     * @param Location $location
     * @param Rotation $rotation
     * @param int $size
     */
    public function __construct(
        Location $location,
        Rotation $rotation,
        $size = 3
    ) {
        // $location will define the centre of the cube
        $this->setLocation($location);

        // Set the rotation around the centre
        $this->setRotation($rotation);

        // Since a cube has regular sides, we should calculate all its points from there
        $this->setPoints($this->generatePoints($size));
    }

    /**
     * @return array
     */
    private function generatePoints($size)
    {
        $zSize = $size * sqrt(2);
        $points = [];
        $degreeIncrements = 15;
        $div = 180/$degreeIncrements;
        // Generate $size*2 rings of 360/$degreeIncrements points.
        $ringLines = [];
        for ($z = - $zSize; $z <= $zSize; $z += $zSize/$div) {
            $dist = sqrt(1 - pow($z/$zSize, 2));

            for ($deg = 0; $deg < 360; $deg += $degreeIncrements) {
                $x = $this->rotateX($size, $size, $deg);
                $y = $this->rotateY($size, $size, $deg);
                $newPoint = new Point(
                    $x * $dist,
                    $y * $dist,
                    $z
                );
                $points[] = $newPoint;
                $ringLines[$z][] = $newPoint;
            }
        }
        // Connect the ring segments
        $verticalLines = [];
        foreach ($ringLines as $z => $currentRingLines) {
            $maxPointInRing = count($currentRingLines) - 1;
            /** @var Point $firstPoint */
            $firstPoint = $currentRingLines[0];
            $lastPoint = $currentRingLines[$maxPointInRing];
            $firstPoint->addLine($lastPoint);
            $lastPoint->addLine($firstPoint);
            /**
             * @var  $key
             * @var Point $currentRingLine
             */
            foreach ($currentRingLines as $key => $currentRingLine) {
                $verticalLines[$key][] = $currentRingLine;
                if (array_key_exists($key + 1, $currentRingLines)) {
                    $currentRingLine->addLine($currentRingLines[$key + 1]);
                }
            }
        }
        // Connect verticals
        foreach ($verticalLines as $verticalSegment) {
            foreach ($verticalSegment as $key => $currentRingLine) {
                if (array_key_exists($key + 1, $verticalSegment)) {
                    $currentRingLine->addLine($verticalSegment[$key + 1]);
                }
            }
        }

        //var_export($points);
        return $points;
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