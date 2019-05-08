<?php

namespace Exdeliver\Causeway\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class CausewayFacade
 *
 * @package Exdeliver\Causeway\Facades
 */
class CausewayServiceFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'causewayservice';
    }
}
