<?php

$importDirectories = [
    "metrics",
    "traits",
    "objects/primitives",
    "objects/cartesian",
    "scenes",
    "engine/transformations",
    "engine/writer",
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
