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

    /**
     * Start the timer
     */
    public function start()
    {
        $this->cursor++;
        $this->start = microtime(true);
    }

    /**
     * @throws \Exception
     */
    public function end()
    {
        if (is_null($this->start)) {
            throw new \Exception("You must call start() before end().");
        }
        $this->end = microtime(true);
        $this->samples[$this->cursor % self::SAMPLES] = $this->getTotal();
    }

    /**
     * Reset the internal state so it behaves like it would when first initialised.
     * We do not need to reset the cursor since its an implementation detail
     * that the consumer does not need to care about.
     */
    public function reset()
    {
        $this->samples = [];
        $this->start = null;
        $this->end = null;
    }

    /**
     * @return null
     * @throws \Exception
     */
    public function getTotal()
    {
        if (is_null($this->start) || is_null($this->end)) {
            throw new \Exception("You must call start() and end() before timing can be calculated");
        }
        return $this->end - $this->start;
    }

    /**
     * @throws \Exception
     */
    public function printAverageTiming()
    {
        if (empty($this->samples)) {
            throw new \Exception("At least one set of samples must be gathered before a value can be returned.");
        }
        $avgTime = round(array_sum($this->samples) / count($this->samples),4);
        echo "Average Frame Time: $avgTime\n";
    }
}