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
        $userData = [];

        return $this->userRepo->create($userData);
    }
}
