<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserInterfaceRepository
{
    public function create(array $data): User;
}
