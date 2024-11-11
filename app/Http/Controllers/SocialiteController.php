<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Filament\Notifications\Notification;

class SocialiteController extends Controller
{
    public function redirect(string $provider, string $panel = 'admin')
    {
        // Store the panel type in session
        Session::put('intended_panel', $panel);

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        try {
            $googleUser = Socialite::driver($provider)->user();
            $panel = Session::get('intended_panel', 'admin');

            DB::beginTransaction();

            // Check if user exists
            $user = User::firstOrNew(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'password' => Hash::make(uniqid()), // Generate random password
                    'google_id' => $googleUser->id,
                ]
            );

            // If user is new
            if (!$user->exists) {
                $user->save();

                // Determine role based on email domain
                $isCompanyEmail = str_ends_with($googleUser->email, '@firstbalfour.com');
                $roleId = $isCompanyEmail ? 1 : 2; // 1 for admin, 2 for employee

                UserRole::create([
                    'user_id' => $user->id,
                    'role_id' => $roleId
                ]);
            }

            // Update Google ID if not set
            if (empty($user->google_id)) {
                $user->google_id = $googleUser->id;
                $user->save();
            }

            DB::commit();

            // Authenticate the user
            Auth::login($user, true);

            // Clear the session
            Session::forget('intended_panel');

            // Determine the redirect path based on panel and role
            if ($panel === 'admin' && $user->hasRole('admin')) {
                return redirect()->to('/admin');
            } elseif ($panel === 'app' && $user->hasRole('employee')) {
                return redirect()->to('/app');
            } else {
                Auth::logout();
                return redirect()->to("/{$panel}/login")
                    ->withErrors(['email' => 'You do not have permission to access this panel.']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);

            $panel = Session::get('intended_panel', 'admin');
            Session::forget('intended_panel');

            return redirect()->to("/{$panel}/login")
                ->withErrors(['email' => 'Authentication failed. Please try again.']);
        }
    }
}
