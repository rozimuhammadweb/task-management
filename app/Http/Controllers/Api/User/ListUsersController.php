<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\User\ListUsersRequest;
use App\Http\Resources\User\UserCollection;
use App\Services\Contracts\User\UserServiceInterface;

class ListUsersController extends BaseController
{
    public function __invoke(ListUsersRequest $request, UserServiceInterface $userService)
    {
        return $this->successResponse(
            data: new UserCollection($userService->get(params: $request->validated())),
            message: __('users.list.success')
        );
    }
}
