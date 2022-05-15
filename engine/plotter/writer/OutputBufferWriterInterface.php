<?php

namespace engine\plotter\writer;

/**
 * @interface
 */
interface OutputBufferWriterInterface
{
    public function write($outputBuffer, $xRes, $yRes);
}