<?php

namespace objects\primitives;

use objects\cartesian\Line;
use objects\cartesian\Location;
use objects\cartesian\Point;
use objects\cartesian\Rotation;
use objects\interfaces\PolygonInterface;

/**
 * @abstract
 */
abstract class Primitive implements PolygonInterface
{
    private Location $location;
    private Rotation $rotation;

    /** @var Point[] */
    private array $points;

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    /**
     * @return Rotation
     */
    public function getRotation(): Rotation
    {
        return $this->rotation;
    }

    /**
     * @param Rotation $rotation
     */
    public function setRotation(Rotation $rotation): void
    {
        $this->rotation = $rotation;
    }

    /**
     * @return Point
     */
    public function getPoints(): array
    {
        return $this->points;
    }

    /**
     * @param Point[] $points
     */
    public function setPoints($points): void
    {
        $this->points = $points;
    }

    public function generateMesh()
    {
        foreach ($this->points as $point) {
            $sums = [];
            foreach ($this->points as $pointCompare) {
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