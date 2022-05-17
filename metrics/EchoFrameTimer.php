<?php

namespace metrics;

/**
 * But why make it into a class?
 * The principle of least knowledge! (Law of demeter)
 *
 * SOLID:
 *
 * Single Responsibility:
 * - Exposes getAverageTotal to the terminal.
 *
 * Open-closed Principle
 * - It could be extended or reused in any way the base AbstractTimer would be.
 *
 * Class EchoFrameTimer
 * @package metrics
 */
class EchoFrameTimer extends AbstractTimer
{
    /**
     * @throws \Exception
     */
    public function printAverageTiming()
    {
        $avgTime = $this->getAverageTotal();
        echo "Average Frame Time: $avgTime\n";
    }
}