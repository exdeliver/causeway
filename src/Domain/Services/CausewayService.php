<?php

namespace Exdeliver\Causeway\Domain\Services;

/**
 * Class CausewayService
 * @package Exdeliver\Causeway\Domain\Services
 */
class CausewayService
{
    /**
     * Get Menu.
     *
     * @param string $name
     * @return Model
     */
    public function getMenu(string $name)
    {
        /** @var MenuService $menuService */
        $menuService = app(MenuService::class);
        return $menuService->render($name);
    }

    /**
     * Get Page.
     *
     * @param string $slug
     * @return Model
     */
    public function getPage(string $slug)
    {
        /** @var PageService $pageService */
        $pageService = app(PageService::class);
        return $pageService->getPage($slug);
    }
}
