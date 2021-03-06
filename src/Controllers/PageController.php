<?php

namespace Exdeliver\Causeway\Controllers;

use Exdeliver\Causeway\Domain\Entities\Page\Page;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * @param Page $pageSlug
     *
     * @return Factory|View
     */
    public function getSlug(Page $pageSlug)
    {
        // Default page view
        $customView = 'site::page.default';

        // Find if custom page exists by slug and use that page
        if (view()->exists('site::page.'.$pageSlug->slug)) {
            $customView = 'site::page.'.$pageSlug->slug;
        }

        $metaTitle = $pageSlug->name;

        return view()->first([$customView, 'site::page.default'], [
            'page' => $pageSlug,
            'metaTitle' => $metaTitle,
        ]);
    }
}
