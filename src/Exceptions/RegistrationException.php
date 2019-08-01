<?php

namespace Exdeliver\Causeway\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class RegistrationException.
 */
class RegistrationException extends Exception
{
    /**
     * Report or log an exception.
     */
    public function report()
    {
        Log::debug('Could not register user. Error: '.$this->getMessage());
    }
}
