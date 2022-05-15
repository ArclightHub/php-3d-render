<?php

namespace scenes;

/**
 * @interface
 */
interface SceneInterface
{
    /**
     * @return array
     */
    public function getSceneObjects(): array;
}