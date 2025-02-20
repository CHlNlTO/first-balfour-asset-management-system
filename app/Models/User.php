<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'id_num',
        'google_id',
        'microsoft_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'user_roles');
    // }

    // public function hasRole($role)
    // {
    //     return $this->roles()->where('name', $role)->exists();
    // }

    // public function hasAnyRole($roles)
    // {
    //     return $this->roles()->whereIn('name', (array) $roles)->exists();
    // }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(CEMREmployee::class, 'id_num', 'id_num');
    }

    public function canAccessFilament(): bool
    {
        return true; // Or your specific logic for admin access
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Optional: Add additional access control logic
        return true; // or more specific conditions
    }
}
