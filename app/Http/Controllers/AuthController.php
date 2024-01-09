<?php

namespace App\Http\Controllers;

use App\Exceptions\UserServiceException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, UserService $userService): JsonResponse
    {
        /** @var User $user */
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
        ]);

        Auth::login($user);
        $token = $userService->createToken($user);

        return new JsonResponse(['token' => $token]);
    }

    /**
     * @throws UserServiceException
     */
    public function login(LoginRequest $request, UserService $userService): JsonResponse
    {
        $credentials = $request->validated();

        /** @var User|null $user */
        $user = $userService->findUserByEmail($request->get('login'))
            ?: $userService->findUserByPhone($request->get('login'));

        if (!$user) {
            throw new UserServiceException('User not found.', 404);
        }

        if (!Hash::check($credentials['password'], $user->getAuthPassword())) {
            throw new UserServiceException('User not found!', 404);
        }

        Auth::login($user);
        $token = $userService->createToken($user);

        return new JsonResponse(['token' => $token]);
    }
}
