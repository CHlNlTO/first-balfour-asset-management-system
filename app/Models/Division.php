<?php

namespace App\Models;

use App\Models\Project;
use App\Models\CostCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    protected $guarded = [];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function activeCostCodes()
    {
        return CostCode::query()
            ->whereHas('project', function ($query) {
                $query->where('division_id', $this->id)
                    ->where('active', true);
            })
            ->distinct()
            ->get();
    }

    public function activeCostCodesThroughProjects()
    {
        return $this->projects()
            ->where('active', true)
            ->with('costcode')
            ->get()
            ->pluck('costcode')
            ->unique();
    }
}
