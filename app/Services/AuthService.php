<?php

namespace App\Http\Services;

use App\Models\User;
use App\Repositories\User\UserInterfaceRepository;

class AuthService
{
    private $userRepo;

    public function __construct(UserInterfaceRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

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
