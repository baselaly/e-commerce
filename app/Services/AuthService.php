<?php

namespace App\Services;

use App\Jobs\SendMailJob;
use App\Mail\MailTemplate;
use App\Models\User;
use App\Repositories\User\UserInterfaceRepository;
use Carbon\Carbon;

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
            'password' => request('password'),
            'verify_code' => uniqid() . time()
        ];

        return $this->userRepo->create($userData);
    }

    public function activate($code): User
    {
        $user = $this->userRepo->getSingleBy(['code' => $code]);
        $this->userRepo->update($user->id, [
            'verified' => true,
            'verify_code' => null
        ]);

        return $user;
    }
}
