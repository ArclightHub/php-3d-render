<?php

use scenes\CachedBasicCubeScene;
use scenes\CachedBasicSphereScene;
use scenes\BasicCubeScene;
use scenes\AngledCubeScene;
use scenes\BasicCylinderScene;
use scenes\BasicSphereScene;
use scenes\BasicHyperboloidScene;
use scenes\AngledSphereScene;
use scenes\DradisScannerScene;
use engine\VoxelScanRenderEngine;
use engine\VertexScanRenderEngine;
use metrics\FrameTimer;

/**
 * The following should generate a well formed cube when using defaults (hit enter at all prompts).
 * clear && php main.php 8 0 0 0 30 30 0
 *
 * ARG #1 - Cube Size
 * ARG #2 - Cube Centre X
 * ARG #3 - Cube Centre Y
 * ARG #4 - Cube Centre X
 * ARG #5 - Cube Rotation
 * ARG #6 - Cube Rotation
 * ARG #7 - Cube Rotation
 *
 *
 *                  00++------++------++00
 *                ..  --              ..  --
 *              ++..    --          ++..    --
 *              ..        --        ..        --
 *            ..++          ++    ..++          ++
 *          ++..              ..++..              ..
 *          ..                  ==                  ++
 *        ..++                ..++--                  --
 *      ++..                ++..    --                  --
 *      ..                  ..        --                  --
 *    ..++                ..++          00++------++------++00
 *    ..                  ..          ..                  ..
 *  00++------++------++00          ++..                ++..
 *    --                  --        ..                  ..
 *      --                  --    ..++                ..++
 *        --                  --++..                ++..
 *          ++                  ==                  ..
 *            ..              ..++..              ..++
 *              ++          ++..    ++          ++..
 *                --        ..        --        ..
 *                  --    ..++          --    ..++
 *                    --  ..              --  ..
 *                      00++------++------++00
 *
 */

require_once 'functions.php';
require_once 'autoload.php';

// Select a resolution
$resolution = askQuestion(null, "Please enter a resolution. (48)", 48);
echo "Output will be a $resolution X $resolution\n";

// Select the scene to render
$scenes = [
    'CachedBasicCubeScene' => CachedBasicCubeScene::class,
    'CachedBasicSphereScene' => CachedBasicSphereScene::class,
    'BasicCubeScene' => BasicCubeScene::class,
    'BasicCylinderScene' => BasicCylinderScene::class,
    'BasicSphereScene' => BasicSphereScene::class,
    'BasicHyperboloidScene' => BasicHyperboloidScene::class,
    'OrthogonalCubeScene' => AngledCubeScene::class,
    'OrthogonalSphereScene' => AngledSphereScene::class,
    'DradisScannerScene' => DradisScannerScene::class,
];
$scene = askQuestion(
    array_keys($scenes),
    "Please select a scene. (" . implode(", ", array_keys($scenes)) . ")",
    'BasicCubeScene'
);
$sceneToRender = new $scenes[$scene](
    $argv[1] ?? null,
    $argv[2] ?? null,
    $argv[3] ?? null,
    $argv[4] ?? null,
    $argv[5] ?? null,
    $argv[6] ?? null,
    $argv[7] ?? null,
);

// Select the render engine to use
$engines = [
    'VoxelScanRenderEngine' => VoxelScanRenderEngine::class,
    'VertexScanRenderEngine' => VertexScanRenderEngine::class
];
$engine = askQuestion(
    ['VoxelScanRenderEngine', 'VertexScanRenderEngine'],
    "Please select a render engine. (VertexScanRenderEngine or VoxelScanRenderEngine)",
    'VertexScanRenderEngine');
$engineClass = $engines[$engine];
echo "Engine: $engineClass\n";
$engine = new $engineClass();

// Animate?
$animate = askQuestion([true, false], "Animate? (0 or 1).", true);

// Render the scene
$frameTimer = new FrameTimer();
$start = microtime(true);
if ($animate) {
    for ($i = 0; $i > -1; $i++) {
		$frameTimer->start();
        $sceneToRender = new $scenes[$scene](
            $argv[1] ?? null,
            $argv[2] ?? null,
            $argv[3] ?? null,
            $argv[4] ?? null,
            $i,
            $i/2,
            $i/3
        );
        $engine->render($sceneToRender, $resolution, $resolution);
        // Wait 5ms before rendering next frame
        $frameTimer->end();
        $frameTimer->printAverageTiming();
        $totalFrameTime = 1/120;
        if ($totalFrameTime > $frameTimer->getTotal()) {
            $wait = (int) (1000000 * ($totalFrameTime - $frameTimer->getTotal()));
            echo "uSeconds before next frame: $wait\n";
            usleep($wait);
        }
    }
}
$engine->render($sceneToRender, $resolution, $resolution);
$end = microtime(true);
$total = $end - $start;
echo "Took $total to render";
echo "\n";
