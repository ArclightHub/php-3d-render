<?php

namespace objects\primitives;

use objects\cartesian\Location;
use objects\cartesian\Point;
use objects\cartesian\Rotation;
use traits\RotatableTrait;

/**
 * SOLID:
 *
 * Single Responsibility:
 * - Encapsulates all the logic required to generate a mesh of points in the shape of a sphere.
 *
 * Open-closed Principle
 * - It can be used as part of a bigger polygon or its lines can be moved to form a different shape.
 *
 * Liskov Substitution Principle
 * - It is a shape which implements the PolygonInterface interface, can be used in any code which uses a polygon.
 *
 * Dependency Inversion Principle
 * - The object has no knowledge of how it will be used.
 *
 * Class Sphere
 * @package objects\primitives
 */
class Sphere extends AbstractPrimitive implements PolygonInterface
{
    use RotatableTrait;

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
        $degreeIncrements = 36; // 15, 30, 36, 60, etc
        $div = 180/$degreeIncrements;
        // Generate rings
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

        return $points;
    }
}