<?php

namespace Exdeliver\Causeway\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class CausewayFacade.
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
