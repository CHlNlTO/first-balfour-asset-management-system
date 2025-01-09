<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peripheral extends Model
{
    use HasFactory;

    protected $primaryKey = 'asset_id'; // Specify the primary key if it's not the default 'id'

    protected $fillable = ['asset_id', 'peripherals_type', 'serial_number', 'specifications', 'manufacturer', 'warranty_expiration'];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function peripheralsType()
    {
        return $this->belongsTo(PeripheralType::class, 'peripherals_type', 'id');
    }

    // Override the getRouteKeyName method
    public function getRouteKeyName()
    {
        return 'asset_id';
    }
}
