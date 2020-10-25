<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserInterfaceRepository
{
    /**
     * @param array $data
     * 
     * @return User
     */
    public function create(array $data): User;
}
