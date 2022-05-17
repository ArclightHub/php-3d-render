<?php

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
