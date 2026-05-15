<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(uniqid()),
                    'role' => 'user',
                ]);
            } else {
                $user->update([
                    'google_id' => $googleUser->getId(),
                ]);
            }
            
            Auth::login($user);
            
            return redirect()->intended(route('home'));
            
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Erreur lors de l\'authentification Google.');
        }
    }
}