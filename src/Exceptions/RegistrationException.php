<?php

namespace Exdeliver\Causeway\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class RegistrationException
 * @package App\Exceptions
 */
class RegistrationException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        Log::debug('Could not register user. Error: ' . $this->getMessage());
    }
}
