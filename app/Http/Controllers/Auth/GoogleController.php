<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            
            $finduser = User::where('google_id', $user->id)->first();
            
            if ($finduser) {
                Auth::login($finduser);
                return redirect()->intended(route('home'));
            } else {
                // Check if email already exists
                $existingUser = User::where('email', $user->email)->first();
                if ($existingUser) {
                    $existingUser->update([
                        'google_id' => $user->id,
                        'avatar' => $user->avatar
                    ]);
                    Auth::login($existingUser);
                    return redirect()->intended(route('home'));
                }

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'avatar' => $user->avatar,
                ]);
         
                Auth::login($newUser);
                return redirect()->intended(route('home'));
            }
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Google Sign-In failed: ' . $e->getMessage());
        }
    }
}
