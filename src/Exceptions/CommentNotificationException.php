<?php

namespace Exdeliver\Causeway\Exceptions;

use Exception;

class CommentNotificationException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        Log::debug('Could not find notification group. Error: ' . $this->getMessage());
    }
}
