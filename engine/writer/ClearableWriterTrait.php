<?php

namespace engine\writer;

/**
 * Purpose: Clears the screen.
 *
 * SOLID:
 *
 * Single Responsibility:
 * - Clears the terminal on either Windows or Linux
 *
 * Dependency Inversion Principle
 * - Inverts the dependency on the host operating system, allowing its implementers to be os agnostic.
 *
 * Trait ClearableWriterTrait
 * @package engine\writer
 */
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