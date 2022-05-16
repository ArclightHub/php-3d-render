<?php

namespace objects\primitives;

use objects\cartesian\Point;

/**
 * Trait GenerateMeshTrait
 * @package objects\primitives
 */
trait GenerateMeshTrait
{
    public function generateMeshForClosestPoints(PolygonInterface $polygon)
    {
        /** @var Point[] $points */
        $points = $polygon->getPoints();
        /** @var Point $point */
        foreach ($points as $point) {
            $sums = [];
            foreach ($points as $pointCompare) {
                if ($point === $pointCompare) {
                    continue;
                }
                $xDiff = abs($point->getX() - $pointCompare->getX());
                $yDiff = abs($point->getY() - $pointCompare->getY());
                $zDiff = abs($point->getZ() - $pointCompare->getZ());
                $vectorSum = sqrt(pow($xDiff, 2) + pow($yDiff, 2) + pow($zDiff, 2));
                $sums[$vectorSum][] = $pointCompare;
            }
            $closest = min(array_keys($sums));
            $point->setLines($sums[$closest]);
        }
    }
}