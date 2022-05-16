<?php

namespace engine\writer;

trait ClearableWriterTrait
{
    public function clearScreen()
    {
        if (PHP_OS == "Linux") {
            system('clear');
        } else {
            system('cls');
        }
    }
}