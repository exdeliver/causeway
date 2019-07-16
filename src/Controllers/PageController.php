<?php

namespace Exdeliver\Causeway\Controllers;

use Exdeliver\Causeway\Domain\Entities\Page\Page;

class PageController extends Controller
{
    /**
     * @param Page $pageSlug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSlug(Page $pageSlug)
    {
        // Default page view
        $customView = 'site::page.default';

        // Find if custom page exists by slug and use that page
        if (view()->exists('causeway.page.' . $pageSlug->slug)) {
            $customView = 'site::page.' . $pageSlug->slug;
        }

        return view()->first([$customView, 'site::page.default'], [
            'page' => $pageSlug,
        ]);
    }
}
