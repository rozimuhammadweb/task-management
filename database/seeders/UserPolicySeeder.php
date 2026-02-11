<?php

namespace Database\Seeders;

use App\Policies\UserPolicy;

class UserPolicySeeder extends BasePolicySeeder
{
    public string $policy = UserPolicy::class;
}
