<?php

namespace Exdeliver\Causeway\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class CausewayCartServiceFacade.
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
