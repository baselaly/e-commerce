<?php

namespace App\Services;

use App\Jobs\SendMailJob;
use App\Mail\MailTemplate;
use App\Models\ForgetPassword;
use App\Models\User;
use App\Repositories\User\UserInterfaceRepository;
use Carbon\Carbon;
use Tymon\JWTAuth\JWT;

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

    public function login(): ?string
    {
        return auth()->attempt([
            'email' => request('email'), 'password' => request('password'),
            'active' => true, 'verified' => true
        ]);
    }

    /**
     * @param string $code
     * 
     * @return bool
     */
    public function activate(string $code): bool
    {
        $user = $this->userRepo->getSingleBy(['code' => $code]);
        return $this->userRepo->update($user->id, [
            'verified' => true,
            'verify_code' => null
        ]);
    }

    /**
     * @param string $email
     * 
     * @return ForgetPassword
     */
    public function forgetPassword(string $email): ForgetPassword
    {
        $user = $this->userRepo->getSingleBy(['email' => $email]);
        if (!$user->forgetPassword) {
            $user->forgetPassword()->create(['code' => uniqid()]);
        }

        $mailData = [
            'subject' => 'Password Reset',
            'message' => 'Please Confirm Your New password',
            'code' => $user->forgetPassword->code,
            'blade' => 'emails.resetPasswordMail'
        ];

        $mail = new MailTemplate($mailData);

        $mailJob = (new SendMailJob($user->email, $mail))->delay(Carbon::now()->addSeconds(5));
        dispatch($mailJob);

        return $user->forgetPassword;
    }
}
