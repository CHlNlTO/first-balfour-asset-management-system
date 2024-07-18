<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    use HasFactory;

    protected $fillable = ['asset_id', 'version', 'license_key', 'license_type'];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
