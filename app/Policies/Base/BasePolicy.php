<?php

namespace App\Policies\Base;

use App\Policies\Base\Contracts\BasePolicyInterface;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class BasePolicy implements BasePolicyInterface
{
    use HandlesAuthorization;
}
