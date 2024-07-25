<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lifecycle extends Model
{
    use HasFactory;

    protected $fillable = ['asset_id', 'acquisition_date', 'retirement_date'];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
