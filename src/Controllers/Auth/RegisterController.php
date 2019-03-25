<?php

namespace Exdeliver\Causeway\Controllers\Auth;

use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Services\UserService;
use Exdeliver\Causeway\Requests\PostRegisterRequest;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

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
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('causeway::auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param PostRegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function register(PostRegisterRequest $request)
    {
        return $this->userService->register($request->only([
            'email', 'password', 'name',
        ]));
    }
}
