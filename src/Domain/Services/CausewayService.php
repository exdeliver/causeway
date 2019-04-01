<?php

namespace Exdeliver\Causeway\Domain\Services;

class CausewayService
{
    /**
     * Get Menu.
     *
     * @param string $name
     * @return mixed
     */
    public function getMenu(string $name)
    {
        $menuService = app(MenuService::class);
        return $menuService->render($name);
    }
}