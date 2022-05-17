<?php

namespace engine;

use scenes\Scene;

/**
 * @interface
 *
 * Interface RenderEngineInterface
 * @package engine
 */
interface RenderEngineInterface
{
    public function render(Scene $scene, $xRes, $yRes);
}