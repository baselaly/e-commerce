<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\User\UserInterfaceRepository;

class AuthService
{
    /**
     * @var UserInterfaceRepository
     */
    private $userRepo;

    /**
     * @param UserInterfaceRepository $userRepo
     */
    public function __construct(UserInterfaceRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @return User
     */
    public function register(): User
    {
        $userData = [
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'password' => request('password')
        ];

        return $this->userRepo->create($userData);
    }
}
