<?php

use scenes\BasicCubeScene;
use scenes\OrthogonalCubeScene;
use scenes\BasicCylinderScene;
use scenes\BasicSphereScene;
use scenes\BasicHyperboloidScene;
use scenes\OrthogonalSphereScene;
use engine\VoxelScanRenderEngine;
use engine\VertexScanRenderEngine;

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

/**
 * Dump Die
 *
 * @param ...$args
 */
function dd(...$args)
{
    if (is_array($args)) {
        foreach ($args as $arg) {
            print_r($arg);
        }
    } else {
        print_r($args);
    }
    die();
}

function askQuestion($options = null, $question = null, $default = null)
{
    if (is_array($options)) {
        $optionsString = implode(", ", $options);
        $question = $question ?? "Please enter one of the following options: (" . $optionsString . ")\n";
    } else {
        $question = $question ?? "Please enter a value\n";
    }
    $input = readline($question);
    if ($default != null && $input == '') {
        return $default;
    }
    if (is_array($options) && !in_array($input, $options)) {
        $message = sprintf(
            "Your entry '%s', is not one of the following options: (%s)\n",
            $input,
            $optionsString
        );
        echo $message;
        $input = askQuestion($options, $question);
    }
    return $input;
}

$importDirectories = [
    "objects/interfaces",
    "objects/primitives",
    "objects/cartesian",
    "scenes",
    "engine/plotter/transformations",
    "engine/plotter/writer",
    "engine/plotter",
    "engine",
];
foreach ($importDirectories as $importDirectory) {
    $scan = scandir("$importDirectory/");
    $loadOrder = [
        '@interface' => true,
        '@abstract' => true,
        'trait' => true,
        'class' => true,
    ];
    foreach (array_keys($loadOrder) as $load) {
        foreach ($scan as $class) {
            if (in_array($class, ['.', '..']) || strpos($class, '.') == false) {
                // Skip directories
                continue;
            }
            $fullPath = "$importDirectory/" . $class;
            //echo "Attempting to load $fullPath as an $load\n";
            $file = file_get_contents($fullPath);
            if (strpos($file, $load) != false) {
                //echo "$load $fullPath loaded\n";
                include_once($fullPath);
            }
        }
    }
}

// Select a resolution
$resolution = askQuestion(null, "Please enter a resolution. (32)", 32);
echo "Output will be a $resolution X $resolution\n";

// Select the scene to render
$scenes = [
    'BasicCubeScene' => BasicCubeScene::class,
    'OrthogonalCubeScene' => OrthogonalCubeScene::class,
    'BasicCylinderScene' => BasicCylinderScene::class,
    'BasicSphereScene' => BasicSphereScene::class,
    'OrthogonalSphereScene' => OrthogonalSphereScene::class,
    'BasicHyperboloidScene' => BasicHyperboloidScene::class,
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
$animate = askQuestion([true, false], "Animate? (0 or 1).", false);

// Render the scene
$start = microtime(true);
if ($animate) {
    for ($i = 0; $i > -1; $i++) {
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
        sleep(0.1);
    }
}
$engine->render($sceneToRender, $resolution, $resolution);
$end = microtime(true);
$total = $end - $start;
echo "Took $total to render";
echo "\n";
