<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class MicrosoftAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('microsoft')->redirect();
    }

    public function callback()
    {
        try {
            $microsoftUser = Socialite::driver('microsoft')->user();

            $user = User::firstOrCreate(
                ['email' => $microsoftUser->email],
                [
                    'name' => $microsoftUser->name,
                    'email' => $microsoftUser->email,
                ]
            );

            // Optional: Domain restriction
            if (!$this->validateUserDomain($user)) {
                return redirect()->route('filament.auth.login')
                    ->withErrors(['email' => 'Unauthorized access']);
            }

            Auth::login($user);

            return redirect()->intended('/admin');
        } catch (\Exception $e) {
            return redirect()->route('filament.auth.login')
                ->withErrors(['email' => 'Authentication failed']);
        }
    }

    protected function validateUserDomain($user)
    {
        // Implement your domain restriction logic
        return str_ends_with($user->email, '@yourcompany.com');
    }
}
