<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionToBuy extends Model
{
    use HasFactory;

    protected $table = 'option_to_buy';

    protected $fillable = [
        'assignment_id',
        'asset_cost',
        'option_to_buy_status',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function status()
    {
        return $this->belongsTo(AssignmentStatus::class, 'option_to_buy_status');
    }
}
