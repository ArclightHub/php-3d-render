<?php

namespace objects\cartesian;

class Point
{
    /** @var int */
    private $x;

    /** @var int */
    private $y;

    /** @var int */
    private $z;

    /** @var Point[] */
    private $lines;

    /**
     * @param $x
     * @param $y
     * @param $z
     */
    public function __construct($x, $y, $z)
    {
        $this->x = number_format($x, 2);
        $this->y = number_format($y, 2);
        $this->z = number_format($z, 2);
    }

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

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @return int
     */
    public function getZ(): int
    {
        return $this->z;
    }

    /**
     * @param int $x
     */
    public function setX(int $x): void
    {
        $this->x = $x;
    }

    /**
     * @param int $y
     */
    public function setY(int $y): void
    {
        $this->y = $y;
    }

    /**
     * @param int $z
     */
    public function setZ(int $z): void
    {
        $this->z = $z;
    }
}