<?php

namespace Exdeliver\Causeway\Domain\Common\Interfaces;

/**
 * Interface RenderableInterface
 * @package Exdeliver\Causeway\Domain\Common\Interfaces
 */
interface RenderableInterface
{
    public function render(): string;
}