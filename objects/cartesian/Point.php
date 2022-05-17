<?php

namespace objects\cartesian;

/**
 * A point is a type of location which connects to other points.
 *
 * SOLID:
 *
 * Single Responsibility:
 * - Encapsulates the logic required to locate a point in space and the points its connected to, this
 *   is sometimes also known as a vertex.
 *
 * Open-closed Principle
 * - The point can be extended by applying transformations to it.
 * - The point can be extended by adding new lines that connect to it.
 *
 * Liskov Substitution Principle
 * - Every instance of a point should be evaluated the same as every other one.
 *
 * Dependency Inversion Principle
 * - The object has no knowledge of how it will be used.
 *
 * Class Point
 * @package objects\cartesian
 */
class Point extends Location
{
    /** @var Point[] */
    private $lines;

    /**
     * @return Point[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * @param Point[] $lines
     */
    public function setLines(array $lines): void
    {
        if (!is_null($this->lines)) {
            foreach ($lines as $line) {
                $this->addLine($line);
            }
        } else {
            $this->lines = $lines;
        }
    }

    /**
     * @param Point $line
     */
    public function addLine(Point $line): void
    {
        $this->lines[] = $line;
    }
}