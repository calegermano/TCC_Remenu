<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends VerifyEmail
{
    use Queueable;

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifique seu email - ' . config('app.name'))
            ->view('emails.verify-email', [
                'verificationUrl' => $verificationUrl,
                'nome' => $notifiable->nome,
            ]);
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}