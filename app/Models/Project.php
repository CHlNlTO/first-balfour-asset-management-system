<?php

namespace App\Models;

use App\Models\Division;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $guarded = [];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function costCode(): HasMany
    {
        return $this->hasMany(CostCode::class);
    }
}
