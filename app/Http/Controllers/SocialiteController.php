<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SocialiteController extends Controller
{
    protected $providerColumnMap = [
        'google' => 'google_id',
        'microsoft' => 'microsoft_id'
    ];

    public function redirect(string $provider, string $panel = 'admin')
    {

        Log::info('Redirecting to provider: ' . $provider);
        // Store the panel type in session
        Session::put('intended_panel', $panel);

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            $panel = Session::get('intended_panel', 'admin');
            $providerColumn = $this->providerColumnMap[$provider] ?? null;

            if (!$providerColumn) {
                throw new \Exception("Unsupported provider: {$provider}");
            }

            Log::info('User: ', [json_encode($socialUser)]);

            DB::beginTransaction();

            // Check if user exists by email or provider ID
            $user = User::where('email', $socialUser->email)
                ->orWhere($providerColumn, $socialUser->id)
                ->first();

            if (!$user) {
                // Create new user
                $user = new User([
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'password' => Hash::make(uniqid()), // Generate random password
                ]);
                $user->$providerColumn = $socialUser->id;
                $user->save();

                // Determine role based on email domain
                // $isCompanyEmail = str_ends_with($socialUser->email, '@firstbalfour.com');
                // $roleId = $isCompanyEmail ? 1 : 2; // 1 for admin, 2 for employee
                $roleId = 1;

                UserRole::create([
                    'user_id' => $user->id,
                    'role_id' => $roleId
                ]);
            } else {
                // Update provider ID if not set
                if (empty($user->$providerColumn)) {
                    $user->$providerColumn = $socialUser->id;
                    $user->save();
                }
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
