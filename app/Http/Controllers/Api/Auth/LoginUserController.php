<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Services\AuthService;
use App\Services\Contracts\Auth\AuthServiceInterface;
use Illuminate\Http\JsonResponse;

class LoginUserController extends BaseController
{
    public function __invoke(LoginUserRequest $request, AuthServiceInterface $authService): JsonResponse
    {
        return $this->successResponse(data: $authService->login($request->validated()), message: __('auth.login_success'));
    }
}
