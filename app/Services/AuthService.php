<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use App\Services\Contracts\Auth\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService extends BaseService implements AuthServiceInterface
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
        parent::__construct($userRepository);
    }

    public function register(array $data)
    {
        $user =  $this->userRepository->create($data);

        $user->assignRole(RoleEnum::USER);

        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token);
    }

    public function login(array $data): array
    {
        $user = $this->userRepository->findByLogin($data['login']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['Username or password is incorrect.'],
            ]);
        }

        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token);
    }


    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(): array
    {
        return $this->respondWithToken(auth()->refresh());
    }


    protected function respondWithToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
