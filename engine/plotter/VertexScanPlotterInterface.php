<?php

namespace engine\plotter;

/**
 * @interface
 */
interface VertexScanPlotterInterface
{
    public function plot(&$outputBuffer);
}