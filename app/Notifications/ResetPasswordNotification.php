<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     * Uses RODTHBAL KCM CMS name and OCT logo (via mail header template).
     */
    public function toMail($notifiable)
    {
        $url = $this->resetUrl($notifiable);
        $appName = config('app.name', 'RODTHBAL KCM CMS');
        $expire = config('auth.passwords.users.expire', 60);

        return (new MailMessage)
            ->subject('Reset Your Password - ' . $appName)
            ->greeting('Hello!')
            ->line('You are receiving this email because we received a password reset request for your account at ' . $appName . '.')
            ->line('Click the button below to choose a new password. This link will expire in ' . $expire . ' minutes.')
            ->action('Reset Password', $url)
            ->line('If you did not request a password reset, no further action is required.')
            ->salutation('Regards, ' . $appName);
    }
}
