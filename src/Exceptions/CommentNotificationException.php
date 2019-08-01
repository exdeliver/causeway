<?php

namespace Exdeliver\Causeway\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentNotificationException extends Exception
{
    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Exception $exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request
     *
     * @return Response
     */
    public function render($request)
    {
        return abort(500);
    }
}
