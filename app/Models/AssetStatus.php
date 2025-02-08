<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetStatus extends Model
{
    use HasFactory;

    protected $fillable = ['asset_status', 'color_id'];

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
