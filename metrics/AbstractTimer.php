<?php

namespace metrics;

/**
 * But why make it into a class?
 * The principle of least knowledge! (Law of demeter)
 *
 * SOLID:
 *
 * Single Responsibility:
 * - Encapsulates all the logic required to track timing for a given start+stop pair.
 * - Exposes data for single or multiple pairs for a consumer.
 *
 * Open-closed Principle
 * - It can be used as part of a bigger engine for timing frames or vsyncing.
 * - Allows computed state (getTotal) to be exposed for use by a consumer, allowing vsyncing.
 * - Allows computed state (getAverageTotal) to be exposed for use by a consumer.
 *
 * Dependency Inversion Principle
 * - The object has no knowledge of how it will be used.
 *
 * Class AbstractTimer
 * @package metrics
 * @abstract
 */
abstract class AbstractTimer
{
    const SAMPLES = 240;

    /** @var int */
    private $cursor = 0;

    /** @var array */
    private $samples = [];

    /** @var null|float */
    private $start = null;

    /** @var null|float */
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
     * @return float|null
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
     * @return false|float
     * @throws \Exception
     */
    public function getAverageTotal()
    {
        if (empty($this->samples)) {
            throw new \Exception("At least one set of samples must be gathered before a value can be returned.");
        }
        return round(array_sum($this->samples) / count($this->samples),4);
    }
}