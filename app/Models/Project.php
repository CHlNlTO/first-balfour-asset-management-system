<?php

namespace App\Models;

use App\Models\Division;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $guarded = [];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function cost_code(): BelongsTo
    {
        return $this->belongsTo(CostCode::class);
    }
}
