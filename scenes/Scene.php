<?php

namespace scenes;

/**
 * @abstract
 */
abstract class Scene implements SceneInterface
{
    private $sceneObjects = [];

    /**
     * @return array
     */
    public function getSceneObjects(): array
    {
        return $this->sceneObjects;
    }

    /**
     * @param $object
     */
    public function addObjectToScene($object)
    {
        $this->sceneObjects[] = $object;
    }
}