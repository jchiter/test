<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function findUserByEmail(string $email): ?User
    {
        if (empty($email)) {
            return null;
        }
        /** @var User $user */
        $user = User::query()
            ->where('email', $email)
            ->first();

        return $user;
    }

    public function findUserByPhone(string $phone): ?User
    {
        if (empty($phone)) {
            return null;
        }
        /** @var User $user */
        $user = User::query()
            ->where('phone', $phone)
            ->first();

        return $user;
    }

    public function createToken(User $user, string $tokenName = null, array $abilities = ['*']): string
    {
        if (!$tokenName) {
            $tokenName = 'auth_token';
        }
        $user->tokens()->delete();

        return $user->createToken($tokenName, $abilities)->plainTextToken;
    }
}
