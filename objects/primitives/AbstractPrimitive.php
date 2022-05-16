<?php

namespace objects\primitives;

use objects\cartesian\Line;
use objects\cartesian\Location;
use objects\cartesian\Point;
use objects\cartesian\Rotation;
use objects\primitives\PolygonInterface;

/**
 * @abstract
 */
abstract class AbstractPrimitive implements PolygonInterface
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
}