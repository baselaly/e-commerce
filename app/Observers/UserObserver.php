<?php

namespace App\Observers;

use App\Jobs\SendMailJob;
use App\Mail\MailTemplate;
use Carbon\Carbon;

class UserObserver
{
    public function created($user)
    {
        // its created from website
        if ($user->verify_code) {
            $mailData = [
                'subject' => 'e-mail verify',
                'message' => 'Please Verify Your Email',
                'token' => $user->verify_code,
                'blade' => 'emails.verifyMail'
            ];

            $mail = new MailTemplate($mailData);

            $mailJob = (new SendMailJob($user->email, $mail))->delay(Carbon::now()->addSeconds(5));
            dispatch($mailJob);
        }
    }
}
