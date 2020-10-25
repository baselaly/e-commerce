<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserInterfaceRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create(array $data): User
    {
        return $this->user->create($data);
    }
}
