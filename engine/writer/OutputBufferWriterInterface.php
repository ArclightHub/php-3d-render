<?php

namespace engine\writer;

/**
 * @interface
 */
interface OutputBufferWriterInterface
{
    public function write($outputBuffer, $xRes, $yRes);
}