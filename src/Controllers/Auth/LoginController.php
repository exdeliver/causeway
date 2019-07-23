<?php

namespace Exdeliver\Causeway\Controllers\Auth;

use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Services\UserService;
use Exdeliver\Causeway\Requests\PostLoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * Class LoginController
 * @package Exdeliver\Causeway\Controllers\Auth
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/causeway/dashboard';

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * Create a new controller instance.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param PostLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(PostLoginRequest $request)
    {
        return $this->userService->login($request->only(['email', 'password', 'remember']));
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->flash('notice', 'You have been logged out...');

        return $this->loggedOut($request) ?: redirect('/causeway/dashboard');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('causeway::auth.login');
    }
}
