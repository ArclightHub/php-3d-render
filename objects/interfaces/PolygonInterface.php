<?php

namespace objects\interfaces;

/**
 * @interface
 */
interface PolygonInterface
{
    public function getLocation();
    public function getRotation();
    public function getPoints();
}