<?php

namespace Exdeliver\Causeway\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class CausewayCartServiceFacade
 *
 * @package Exdeliver\Causeway\Facades
 */
class CausewayCartServiceFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'causewaycartservice';
    }
}
