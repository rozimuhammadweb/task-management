<?php

namespace Database\Seeders;

use App\Policies\TaskPolicy;

class TaskPolicySeeder extends BasePolicySeeder
{
    public string $policy = TaskPolicy::class;

}
