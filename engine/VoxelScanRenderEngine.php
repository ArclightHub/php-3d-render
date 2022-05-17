<?php

namespace engine;

use engine\plotter\VectorIntersectionVoxelScanPlotter;
use engine\writer\EchoOutputBufferWriter;
use objects\primitives\PolygonInterface;
use scenes\Scene;

/**
 * Takes a Scene and an XY resolution pair and uses the VectorIntersectionVoxelScanPlotter to plot the $outputBuffer
 * Uses the EchoOutputBufferWriter to write to the terminal.
 *
 * This code is intentionally naive and inefficient
 *
 * This is the BAD example of the RenderEngine concept.
 * See VertexScanRenderEngine for the good example.
 *
 * SOLID:
 *
 * Single Responsibility:
 * - GOOD: Allows the VectorIntersectionVoxelScanPlotter to update the $outputBuffer for all objects in the $scene.
 *
 * Open-closed Principle:
 * - BAD: In this example, the $x, $y and $z are iterated, this is an implementation detail that should be part of the plotter.
 * - BAD: Due to the above issue, the plot function on the plotter takes more parameters than needed.
 *
 * Liskov Substitution Principle
 * - GOOD: Since it implements the RenderEngineInterface interface, can be used in any code which uses a render engine.
 * - BAD: Since it sets values like 'solid' directly to the output buffer any writer used must implement it.
 *
 * Interface Segregation Principle:
 * - GOOD: Even though it does a bad open-closed job, the plotter interface is still segregated by the VoxelScanPlotterInterface
 *
 * Dependency Inversion Principle
 * - BAD: Knows that the VectorIntersectionVoxelScanPlotter updates the buffer for a given object and XYZ triad.
 * - GOOD: Does not know how BatchedEchoOutputBufferWriter outputs the buffer.
 *
 * Class VoxelScanRenderEngine
 * @package engine
 */
class VoxelScanRenderEngine implements RenderEngineInterface
{
    const OUTPUT_MAX_DEPTH = 20.0;
    const STEP_RESOLUTION = 1.0;

    public function render(Scene $scene, $xRes, $yRes)
    {
        $outputBuffer = [];
        for ($x = 0; $x < $xRes; $x += self::STEP_RESOLUTION) {
            for ($y = 0; $y < $yRes; $y += self::STEP_RESOLUTION) {
                for ($z = self::OUTPUT_MAX_DEPTH; $z > 0; $z -= self::STEP_RESOLUTION) {
                    /** @var PolygonInterface $sceneObject */
                    foreach ($scene->getSceneObjects() as $sceneObject) {
                        $plotter = new VectorIntersectionVoxelScanPlotter($sceneObject);
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