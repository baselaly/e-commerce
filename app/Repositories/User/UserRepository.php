<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserInterfaceRepository
{
    /**
     * @var User
     */
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param array $data
     * 
     * @return User
     */
    public function create(array $data): User
    {
        return $this->user->create($data);
    }
}
