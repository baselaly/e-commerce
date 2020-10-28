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

    /**
     * @param array $data
     * 
     * @return User
     */
    public function getSingleBy(array $data): User;

    /**
     * @param array $data
     * 
     * @return bool
     */
    public function update(User $user, array $data): bool;
}
