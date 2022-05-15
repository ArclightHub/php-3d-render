<?php

namespace engine;

use engine\plotter\VertexScanPlotter;
use engine\plotter\writer\BatchedEchoOutputBufferWriter;
use objects\interfaces\PolygonInterface;
use scenes\Scene;

class VertexScanRenderEngine
{
    public function render(Scene $scene, $xRes, $yRes)
    {
        $plotterClass = VertexScanPlotter::class;
        echo "Plotter: $plotterClass\n";
        $outputBuffer = [];
        /** @var PolygonInterface $sceneObject */
        foreach ($scene->getSceneObjects() as $sceneObject) {
            $plotter = new $plotterClass($sceneObject);
            $plotter->plot($outputBuffer);
        }

        // Output the buffer
        $writer = new BatchedEchoOutputBufferWriter();
        $writer->write($outputBuffer, $xRes, $yRes);
    }
}