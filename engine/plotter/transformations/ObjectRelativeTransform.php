<?php

namespace engine\plotter\transforms;

use objects\cartesian\Location;
use objects\cartesian\Point;
use objects\interfaces\PolygonInterface;

class ObjectRelativeTransform
{
    /**
     * @param PolygonInterface $object
     * @param Point $point
     * @return Point
     */
    public function transform($object, $point)
    {
        /** @var Location $objectLocation */
        $objectLocation = $object->getLocation();
        return new Point(
            $point->getX() + $objectLocation->getX(),
            $point->getY() + $objectLocation->getY(),
            $point->getZ() + $objectLocation->getZ(),
        );
    }

}