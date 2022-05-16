<?php

namespace engine\writer;

class BatchedEchoOutputBufferWriter implements OutputBufferWriterInterface
{
    use ClearableWriterTrait;

    const PIXEL_OFF = '  ';
    const PIXEL_LOWEST = '..';
    const PIXEL_QUAD = '--';
    const PIXEL_HALF = '++';
    const PIXEL_FULL = '==';
    const PIXEL_CORNER = '00';

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
        $lines = [];
        $border = '';
        for ($x = 0; $x < $xRes; $x++) {
            if ($border == '') {
                for ($y = 0; $y <= $yRes; $y++) {
                    $border .= self::PIXEL_CORNER;
                }
            }
            if (!isset($lines[$x])) {
                $lines[$x] = '';
            }
            for ($y = 0; $y < $yRes; $y++) {
                if (!isset($outputBuffer[$x][$y])) {
                    $lines[$x] .= self::PIXEL_OFF;
                } else if($outputBuffer[$x][$y] === 'solid') {
                    $lines[$x] .= self::PIXEL_CORNER;
                }  else if ($outputBuffer[$x][$y] == 0) {
                    $lines[$x] .= self::PIXEL_OFF;
                } else if($outputBuffer[$x][$y] == $depth1) {
                    $lines[$x] .= self::PIXEL_LOWEST;
                }  else if($outputBuffer[$x][$y] == $depth2) {
                    $lines[$x] .= self::PIXEL_QUAD;
                } else if($outputBuffer[$x][$y] <= $depth3) {
                    $lines[$x] .= self::PIXEL_HALF;
                } else {
                    $lines[$x] .= self::PIXEL_FULL;
                }
            }
        }
        echo $border . "\n";
        for ($x = 0; $x < $xRes; $x++) {
            echo self::PIXEL_CORNER . $lines[$x] . self::PIXEL_CORNER . "\n";
        }
        echo $border . "\n";
    }
}