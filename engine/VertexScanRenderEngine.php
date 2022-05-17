<?php

namespace engine;

use engine\plotter\VertexScanPlotter;
use engine\writer\BatchedEchoOutputBufferWriter;
use objects\primitives\PolygonInterface;
use scenes\Scene;

/**
 * Takes a Scene and an XY resolution pair and uses the VertexScanPlotter to plot the $outputBuffer
 * Uses the BatchedEchoOutputBufferWriter to write to the terminal.
 *
 * This is the GOOD example of the RenderEngine concept.
 * See VoxelScanRenderEngine for the bad example.
 *
 * SOLID:
 *
 * Single Responsibility:
 * - Allows the VertexScanPlotter to update the $outputBuffer for all objects in the $scene.
 *
 * Liskov Substitution Principle
 * - Since it implements the RenderEngineInterface interface, can be used in any code which uses a render engine.
 *
 * Interface Segregation Principle:
 * - The plotter interface is segregated by the VertexScanPlotterInterface
 *
 * Dependency Inversion Principle
 * - Does not know how VertexScanPlotter updates the buffer.
 * - Does not know how BatchedEchoOutputBufferWriter outputs the buffer.
 *
 * Class VertexScanRenderEngine
 * @package engine
 */
class VertexScanRenderEngine implements RenderEngineInterface
{
    public function render(Scene $scene, $xRes, $yRes)
    {
        $outputBuffer = [];
        /** @var PolygonInterface $sceneObject */
        foreach ($scene->getSceneObjects() as $sceneObject) {
            $plotter = new VertexScanPlotter($sceneObject);
            $plotter->plot($outputBuffer);
        }

        // Output the buffer
        $writer = new BatchedEchoOutputBufferWriter();
        $writer->write($outputBuffer, $xRes, $yRes);
    }
}