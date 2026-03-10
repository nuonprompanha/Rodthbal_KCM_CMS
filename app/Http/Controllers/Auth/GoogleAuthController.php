<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LastLoginService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     * Create or update user with user_type = public, then log in.
     */
    public function callback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            $user->update([
                'name' => $googleUser->getName() ?? $user->name,
                'email_verified_at' => $user->email_verified_at ?? now(),
                'user_type' => User::TYPE_PUBLIC,
            ]);
        } else {
            $user = User::create([
                'name' => $googleUser->getName() ?? 'User',
                'email' => $googleUser->getEmail(),
                'email_verified_at' => now(),
                'password' => null,
                'user_type' => User::TYPE_PUBLIC,
                'is_approved' => true,
            ]);
        }

        $user->update(LastLoginService::getLastLoginData(request()));

        Auth::login($user, true);

        if ($user->canAccessDashboard()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        return redirect('/')->with('status', 'You are logged in with Google. Your account has public access (no dashboard).');
    }
}
