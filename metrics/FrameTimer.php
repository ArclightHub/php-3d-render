<?php

namespace metrics;

/**
 * But why make it into a class?
 * The principle of least knowledge! (Law of demeter)
 *
 * Class FrameTimer
 * @package metrics
 */
class FrameTimer
{
    const SAMPLES = 240;
    private $cursor = 0;
    private $samples = [];
    private $start = null;
    private $end = null;

    public function start()
    {
        $this->cursor++;
        $this->start = microtime(true);
    }

    public function end()
    {
        $this->end = microtime(true);
        $this->samples[$this->cursor % self::SAMPLES] = $this->getTotal();
    }

    public function getTotal()
    {
        return $this->end - $this->start;
    }

    public function printAverageTiming()
    {
        $avgTime = round(array_sum($this->samples) / count($this->samples),4);
        echo "Average Frame Time: $avgTime\n";
    }
}