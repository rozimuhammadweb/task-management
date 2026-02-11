<?php

namespace App\Services;

use App\Repositories\Contracts\User\UserRepositoryInterface;
use App\Services\Contracts\User\UserServiceInterface;

class UserService extends BaseService implements UserServiceInterface
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct($userRepository);
    }
}
