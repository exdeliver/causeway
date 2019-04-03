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
        $pageView = 'causeway::page.default';

        if (view()->exists('page.custom.default')) {
            $pageView = 'page.custom.default';
        }

        // Find if custom page exists by slug and use that page
        if (view()->exists('page.custom.' . $pageSlug->slug)) {
            $pageView = 'page.custom.' . $pageSlug->slug;
        }

        return view($pageView, [
            'page' => $pageSlug,
        ]);
    }
}