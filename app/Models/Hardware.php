<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    use HasFactory;

    protected $primaryKey = 'asset_id'; // Specify the primary key if it's not the default 'id'

    protected $fillable = ['asset_id', 'hardware_type', 'serial_number', 'specifications', 'manufacturer', 'warranty_expiration', 'mac_address', 'accessories'];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'id');
    }

    public function software()
    {
        return $this->belongsToMany(
            Software::class,
            'hardware_software',
            'hardware_asset_id',
            'software_asset_id'
        );
    }

    public function hardwareType()
    {
        return $this->belongsTo(HardwareType::class, 'hardware_type', 'id');
    }

    // Override the getRouteKeyName method
    public function getRouteKeyName()
    {
        return 'asset_id';
    }
}
