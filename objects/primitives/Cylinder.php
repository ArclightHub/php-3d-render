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
 * - Encapsulates all the logic required to generate a mesh of points in the shape of a cylinder.
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
 * Class Cylinder
 * @package objects\primitives
 */
class Cylinder extends AbstractPrimitive implements PolygonInterface
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
        $size = $size * (1/sqrt(2));
        $points = [];
        $degreeIncrements = 30;
        // Generate $size*2 rings of 360/$degreeIncrements points.
        $ringLines = [];
        for ($z = - ($size * 1.5); $z <= ($size * 1.5); $z+= $size/3) {
            $z = round($z);
            $zRadius = $size;
            $currentRingLines = [];
            for ($deg = 0; $deg < 360; $deg += $degreeIncrements) {
                $x = $this->rotateX($zRadius, $zRadius, $deg);
                $y = $this->rotateY($zRadius, $zRadius, $deg);
                $newPoint = new Point(
                    $x,
                    $y,
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