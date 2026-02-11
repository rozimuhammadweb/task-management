<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\User\ListUsersRequest;
use App\Services\UserService;

class ListUsersController extends BaseController
{
    public function __invoke(ListUsersRequest $request, UserService $userService)
    {
        return $this->successResponse(data: $userService->get(params: $request->validated()), message: __('users.list.success'));
    }
}
