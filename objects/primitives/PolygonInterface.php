<?php

namespace objects\primitives;

/**
 * @interface
 */
interface PolygonInterface
{
    public function getLocation();
    public function getRotation();
    public function getPoints();
}