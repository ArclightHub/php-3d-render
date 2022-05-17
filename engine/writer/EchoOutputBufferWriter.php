<?php

namespace engine\writer;

/**
 * Takes the output buffer and echos it to the terminal.
 *
 * SOLID:
 *
 * Single Responsibility:
 * - Outputs the buffer to the terminal using characters based on the plotters weightings.
 *
 * Liskov Substitution Principle
 * - Implements the OutputBufferWriterInterface interface, can be used in any code which uses an OutputBufferWriterInterface.
 *
 * Dependency Inversion Principle
 * - Inverts the engines high level rendering from the low level output mechanism.
 *
 * Class EchoOutputBufferWriter
 * @package engine\writer
 */
class EchoOutputBufferWriter implements OutputBufferWriterInterface
{
    use ClearableWriterTrait;

    const PIXEL_OFF = "\033[0m  ";
    const PIXEL_LOWEST = "\e[0;32m..";
    const PIXEL_QUAD = "\e[0;33m--";
    const PIXEL_HALF = "\e[0;33m++";
    const PIXEL_FULL = "\e[0;31m==";
    const PIXEL_CORNER = "\e[0;36m00";

    public function write($outputBuffer, $xRes, $yRes)
    {
        $this->clearScreen();
        // Output the buffer
        $deepest = [];
        for ($x = 0; $x < $xRes; $x++) {
            for ($y = 0; $y < $yRes; $y++) {
                if (isset($outputBuffer[$x][$y])) {
                    if (!isset($deepest[$outputBuffer[$x][$y]])) {
                        $deepest[$outputBuffer[$x][$y]] = 0;
                    }
                    $deepest[$outputBuffer[$x][$y]]++;
                }
            }
        }
        $depth1 = $depth2 = $depth3 = 0;
        ksort($deepest);
        foreach ($deepest as $depth => $count) {
            if ($depth < 2) {
                continue;
            }
            if ($depth1 == 0) {
                $depth1 = $depth;
                continue;
            }
            if ($depth1 != 0 && $depth2 == 0) {
                $depth2 = $depth;
                continue;
            }
            if ($depth2 != 0 && $depth3 == 0) {
                $depth3 = $depth;
            }
        }
        for ($x = 0; $x < $xRes; $x++) {
            for ($y = 0; $y < $yRes; $y++) {
                if (!isset($outputBuffer[$x][$y])) {
                    echo self::PIXEL_OFF;
                } else if($outputBuffer[$x][$y] === 'solid') {
                    echo self::PIXEL_CORNER;
                }  else if ($outputBuffer[$x][$y] == 0) {
                    echo self::PIXEL_OFF;
                } else if($outputBuffer[$x][$y] == $depth1) {
                    echo self::PIXEL_LOWEST;
                }  else if($outputBuffer[$x][$y] == $depth2) {
                    echo self::PIXEL_QUAD;
                } else if($outputBuffer[$x][$y] <= $depth3) {
                    echo self::PIXEL_HALF;
                } else {
                    echo self::PIXEL_FULL;
                }
            }
            echo "\n";
        }
    }
}