<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Services\AuthService;
use App\Services\Contracts\Auth\AuthServiceInterface;
use Illuminate\Http\JsonResponse;

class RegisterUserController extends BaseController
{
    public function __invoke(RegisterUserRequest $request, AuthServiceInterface $authService): JsonResponse
    {
        return $this->createdResponse(data: $authService->register($request->validated()), message: __('auth.register_success'));
    }
}
