<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(24)), // random password
                ]
            );

            // Always update Google ID if it has changed
            if ($user->google_id !== $googleUser->getId()) {
                $user->google_id = $googleUser->getId();
                $user->save();
            }

            // Automatically remember user on login
            Auth::login($user, true); // <--- "true" enables persistent login

            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['google' => 'Login failed: ' . $e->getMessage()]);
        }
    }
}
