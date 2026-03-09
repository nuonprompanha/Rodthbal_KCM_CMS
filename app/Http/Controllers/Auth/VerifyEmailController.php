<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return $user->canAccessDashboard()
                ? redirect()->intended(route('dashboard', absolute: false))->with('status', 'Your email is already verified.')
                : redirect('/')->with('status', 'Your email is already verified.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $user->canAccessDashboard()
            ? redirect()->intended(route('dashboard', absolute: false))->with('status', 'Your email has been verified. You can now access the dashboard.')
            : redirect('/')->with('status', 'Your email has been verified.');
    }
}
