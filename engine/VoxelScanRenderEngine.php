<?php

namespace engine;

use engine\plotter\VectorIntersectionVoxelScanPlotter;
use engine\plotter\FastPointVoxelScanPlotter;
use engine\writer\EchoOutputBufferWriter;
use objects\interfaces\PolygonInterface;
use scenes\Scene;

class VoxelScanRenderEngine
{
    const OUTPUT_MAX_DEPTH = 20.0;
    const STEP_RESOLUTION = 1.0;

    public function render(Scene $scene, $xRes, $yRes)
    {
        $plotterClass = VectorIntersectionVoxelScanPlotter::class;
        echo "Plotter: $plotterClass\n";
        $outputBuffer = [];
        for ($x = 0; $x < $xRes; $x += self::STEP_RESOLUTION) {
            for ($y = 0; $y < $yRes; $y += self::STEP_RESOLUTION) {
                for ($z = self::OUTPUT_MAX_DEPTH; $z > 0; $z -= self::STEP_RESOLUTION) {
                    /** @var PolygonInterface $sceneObject */
                    foreach ($scene->getSceneObjects() as $sceneObject) {
                        $plotter = new $plotterClass($sceneObject);
                        if (!isset($outputBuffer[$x][$y])) {
                            $outputBuffer[$x][$y] = 0;
                        }
                        if ($outputBuffer[$x][$y] === 'solid') {
                            continue;
                        }
                        $result = $plotter->plot($x, $y, $z);
                        if ($result == -1) {
                            $outputBuffer[$x][$y] = 'solid';
                        } else {
                            $outputBuffer[$x][$y] += $result;
                        }
                    }
                }
            }
        }

        // Output the buffer
        $writer = new EchoOutputBufferWriter();
        $writer->write($outputBuffer, $xRes, $yRes);
    }
}