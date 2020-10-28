<?php

namespace App\Services;

use App\Jobs\SendMailJob;
use App\Mail\MailTemplate;
use App\Models\ForgetPassword;
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
        if (!$user = $this->userRepo->getSingleBy(['code' => $code])) {
            return false;
        }

        return $this->userRepo->update($user, [
            'verified' => true,
            'verify_code' => null
        ]);
    }

    /**
     * @param string $email
     * 
     * @return ForgetPassword
     */
    public function forgetPassword(string $email): ?ForgetPassword
    {
        if (!$user = $this->userRepo->getSingleBy(['email' => $email])) {
            return null;
        }

        if (!$user->forgetPassword) {
            $user->forgetPassword()->create(['code' => uniqid()]);
            $user->refresh();
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

    /**
     * 
     * @return void
     */
    public function resetPassword(): void
    {
        $forgetPassword = ForgetPassword::where(['code' => request('code')])->firstOrFail();

        $forgetPassword->user->update(['password' => request('password')]);
        $forgetPassword->delete();
    }

    /**
     * 
     * @return User
     */
    public function update(): User
    {
        $data = [
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'phone' => request('phone'),
        ];
        request('image') ? $data['image'] = request('image') : '';
        request('password') ? $data['password'] = request('password') : '';

        $this->userRepo->update(auth()->user(), $data);

        return auth()->user();
    }
}
