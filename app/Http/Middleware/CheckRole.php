<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            $intendedUrl = $request->url();
            $loginPath = str_contains($intendedUrl, '/admin') ? '/admin/login' : '/app/login';
            return redirect($loginPath)->with('error', 'Please log in to access this page.');
        }

        if (!Auth::user()->hasAnyRole($roles)) {
            $dashboardPath = Auth::user()->hasRole('admin') ? '/admin' : '/app';

            Notification::make()
                ->title('Access Denied')
                ->body('You do not have permission to access this page.')
                ->danger()
                ->send();

            return redirect($dashboardPath);
        }

        return $next($request);
    }
}