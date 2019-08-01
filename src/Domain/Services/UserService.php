<?php

namespace Exdeliver\Causeway\Domain\Services;

use App\Exceptions\RegistrationException;
use Exception;
use Exdeliver\Causeway\Domain\Entities\User\User;
use Exdeliver\Causeway\Events\CausewayRegistered;
use Exdeliver\Causeway\Infrastructure\Repositories\UserRepository;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

/**
 * Class UserService.
 */
final class UserService extends AbstractService
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/causeway/dashboard';

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * @param int $userId
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function findGroupsByUserId(int $userId)
    {
        try {
            $user = $this->repository->where('id', '=', $userId)->first();

            return $user->groups ?? null;
        } catch (Exception $e) {
            throw new Exception('Could not find user by id: '.$userId);
        }
    }

    /**
     * @param array $params
     *
     * @return JsonResponse
     */
    public function login(array $params)
    {
        $json = request()->wantsJson();

        if (Auth::attempt($params)) {
            return true === $json ? response()->json(['status' => true, 'redirect_url' => route('causeway.dashboard')]) : redirect()->route('causeway.dashboard');
        }

        if (true === $json) {
            return response()->json([
                'status' => false, 'errors' => [
                    'email' => ['Invalid email and or password combination.'],
                    'password' => ['Forgot your password? Please request one.'],
                ],
            ], 400);
        }

        return redirect()
            ->to()
            ->withErrors();
    }

    /**
     * @param array $params
     *
     * @return RedirectResponse|Redirector
     *
     * @throws Throwable
     */
    public function register(array $params)
    {
        try {
            $user = DB::transaction(function () use ($params) {
                $user = config('auth.providers.users.model')::create([
                    'name' => $params['name'],
                    'email' => $params['email'],
                    'password' => Hash::make($params['password']),
                ]);

                // Default role for all users
                $user->assignRole('user');

                event(new CausewayRegistered($user));

                return $user;
            });

            return response()->json(['status' => true, 'message' => 'Welcome '.$user->name]);
        } catch (RegistrationException $e) {
            report($e);

            return response()->json([
                'status' => false, 'errors' => [
                    'email' => ['Could not register this user.'],
                ],
            ], 400);
        }
    }

    /**
     * @param array   $match
     * @param Request $request
     */
    public function updateOrCreateWithRoles(array $match, Request $request)
    {
        if (!isset($match)) {
            $request->request->add(['password' => Hash::make(str_random(12))]);
        }

        /** @var User $user */
        $user = $this->updateOrCreate($match, $request->only([
            'name', 'email', 'password', 'first_name', 'last_name',
        ]));

        $user->syncRoles($request->only(['roles']));

        if (!$user->hasVerifiedEmail()) {
            event(new CausewayRegistered($user));
        }
    }
}
