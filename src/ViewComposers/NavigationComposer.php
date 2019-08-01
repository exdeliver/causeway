<?php

namespace Exdeliver\Causeway\ViewComposers;

use CW;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class NavigationComposer.
 */
class NavigationComposer
{
    /**
     * @param $view
     */
    public function compose($view)
    {
        try {
            $siteMenu = CW::getMenu('site-menu');
        } catch (Exception $e) {
            Log::error('No site-menu found.');
            $siteMenu = null;
        }

        $view->with('site_menu', $siteMenu);
    }
}
