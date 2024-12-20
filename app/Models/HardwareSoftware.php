<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class HardwareSoftware extends Pivot
{
    protected $table = 'hardware_software';

    protected $fillable = [
        'hardware_asset_id',
        'software_asset_id'
    ];

    public function hardware()
    {
        return $this->belongsTo(Hardware::class, 'hardware_asset_id', 'asset_id');
    }

    public function software()
    {
        return $this->belongsTo(Software::class, 'software_asset_id', 'asset_id');
    }
}
