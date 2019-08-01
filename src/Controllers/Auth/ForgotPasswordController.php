<?php

namespace Exdeliver\Causeway\Controllers\Auth;

use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Requests\PostRequestPasswordRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return Response
     */
    public function showLinkRequestForm()
    {
        return view('causeway::auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param PostRequestPasswordRequest $request
     *
     * @return RedirectResponse|JsonResponse
     */
    public function sendResetLinkEmail(PostRequestPasswordRequest $request)
    {
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return Password::RESET_LINK_SENT === $response
            ? response()->json(['status' => true, 'message' => trans($response)])
            : response()->json(['status' => false, ['errors' => ['email' => trans($response)]]]);
    }
}
