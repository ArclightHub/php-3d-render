<?php

namespace engine\plotter;

/**
 * @interface
 */
interface VoxelScanPlotterInterface
{
    public function plot($x, $y, $z);
}