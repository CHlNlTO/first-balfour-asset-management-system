<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'employee_id',
        'assignment_status',
        'start_date',
        'end_date',
        'remarks',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(CEMREmployee::class, 'employee_id', 'id_num');
    }

    public function optionToBuy()
    {
        return $this->hasOne(OptionToBuy::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(AssignmentStatus::class, 'assignment_status');
    }
}
