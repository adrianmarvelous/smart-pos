<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

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
            session(['user_id' => $user->id]);
            session(['name' => $googleUser->getName()]);
            session(['email' => $googleUser->getEmail()]);

            $store = Store::where('user_id',$user->id)->first();
            if(isset($store))
            {
                session(['store_id' => $store->id]);
            }

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
    
    public function logout(Request $request)
    {
        Auth::logout(); // Logs the user out

        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
}
