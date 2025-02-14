<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LifecycleRenewal extends Model
{
    use HasFactory;

    protected $fillable = [
        'lifecycle_id',
        'user_id',
        'old_retirement_date',
        'new_retirement_date',
        'is_automatic',
        'remarks',
    ];

    protected $casts = [
        'old_retirement_date' => 'datetime',
        'new_retirement_date' => 'datetime',
        'is_automatic' => 'boolean',
    ];

    public function lifecycle(): BelongsTo
    {
        return $this->belongsTo(Lifecycle::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
