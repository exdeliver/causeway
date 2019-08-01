<?php

namespace Exdeliver\Causeway\Domain\Services;

/**
 * Class CausewayService.
 */
final class CausewayService
{
    /**
     * Get Menu.
     *
     * @param string      $name
     * @param string|null $template
     *
     * @return Model
     */
    public function getMenu(string $name, string $template = null)
    {
        /** @var MenuService $menuService */
        $menuService = app(MenuService::class);

        return $menuService->render($name, $template);
    }

    /**
     * Get Page.
     *
     * @param string $slug
     *
     * @return Model
     */
    public function getPage(string $slug)
    {
        /** @var PageService $pageService */
        $pageService = app(PageService::class);

        return $pageService->getPage($slug);
    }
}
