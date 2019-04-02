<?php

namespace Exdeliver\Causeway\Domain\Services;

use App\Exceptions\RegistrationException;
use Exdeliver\Causeway\Domain\Entities\User\User;
use Exdeliver\Causeway\Events\CausewayRegistered;
use Exdeliver\Causeway\Infrastructure\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class PandaUserService
 *
 * @package Domain\Services
 */
class UserService extends AbstractService
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/causeway/dashboard';

    /**
     * PandaUserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * @param int $userId
     * @return mixed
     * @throws \Exception
     */
    public function findGroupsByUserId(int $userId)
    {
        try {
            $user = $this->repository->where('id', '=', $userId)->first();
            return $user->groups ?? null;
        } catch (\Exception $e) {
            throw new \Exception('Could not find user by id: ' . $userId);
        }
    }

    /**
     * @param array $params
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(array $params)
    {
        $json = request()->wantsJson();

        if (Auth::attempt($params)) {
            return $json === true ? response()->json(['status' => true]) : redirect()->to('/causeway/dashboard');
        }

        if ($json === true) {
            return response()->json([
                'status' => false, 'errors' => [
                    'email' => ['Invalid email and or password combination.'],
                    'password' => ['Forgot your password? Please request one.'],
                ],
            ], 400);
        }

        return redirect()
            ->back()
            ->withErrors();

    }

    /**
     * @param array $params
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
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

            return response()->json(['status' => true, 'message' => 'Welcome ' . $user->name]);
        } catch (RegistrationException $e) {
            report($e);
            return response()->json([
                'status' => false, 'errors' => [
                    'email' => ['Could not register this user.'],
                ],
            ], 400);
        }
    }
}