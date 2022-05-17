<?php

namespace objects\primitives;

use objects\cartesian\Location;
use objects\cartesian\Point;
use objects\cartesian\Rotation;

/**
 * Abstract Primitive shape class which contains the functions that shapes will likely need.
 *
 * SOLID:
 *
 * Single Responsibility:
 * - Offloads the logic required by the PolygonInterface to get/set the properties from each child primitive.
 *
 * Open-closed Principle
 * - The various primitives should extend it and the interfact as a contract.
 *
 * Liskov Substitution Principle
 * - It is an abstract shape which implements the PolygonInterface interface, can be used in any code which uses a polygon.
 *
 * Dependency Inversion Principle
 * - The object has no knowledge of how it will be used.
 *
 * @abstract
 */
abstract class AbstractPrimitive implements PolygonInterface
{
    /** @var Location */
    private Location $location;

    /** @var Rotation */
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