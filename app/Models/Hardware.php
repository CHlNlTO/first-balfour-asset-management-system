<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    use HasFactory;

    protected $fillable = ['asset_id', 'specifications', 'serial_number', 'manufacturer', 'warranty_expiration'];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
