<?php

namespace objects\primitives;

use objects\cartesian\Location;
use objects\cartesian\Point;
use objects\cartesian\Rotation;

class Hyperboloid extends AbstractPrimitive implements PolygonInterface
{
    use GenerateMeshTrait;

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

        // Now calculate the lines from the points.
        $this->generateMeshForClosestPoints($this);
    }

    /**
     * @return array
     */
    private function generatePoints($size)
    {
        $points = [];
        $degreeIncrements = 45;
        // Generate $size*2 rings of 360/$degreeIncrements points.
        for ($z = - $size; $z <= $size; $z+= $size/2) {
            $currentRingLines = [];
            for ($deg = 0; $deg < 360; $deg += $degreeIncrements) {
                $x = $this->rotateX($size, $size, $deg);
                $y = $this->rotateY($size, $size, $deg);
                $dist = sqrt(abs(1 - pow($z, 2))) / $size;
                $newPoint = new Point(
                    $x * $dist,
                    $y * $dist,
                    $z
                );
                $points[] = $newPoint;
                $currentRingLines[] = $newPoint;
            }
            // Connect the ring segments
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
                if (array_key_exists($key + 1, $currentRingLines)) {
                    $currentRingLine->addLine($currentRingLines[$key + 1]);
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