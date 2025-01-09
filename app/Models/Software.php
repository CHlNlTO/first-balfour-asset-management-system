<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    use HasFactory;

    protected $primaryKey = 'asset_id'; // Specify the primary key if it's not the default 'id'

    protected $fillable = ['asset_id', 'version', 'license_key', 'software_type', 'license_type', 'pc_name'];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function hardware()
    {
        return $this->belongsToMany(
            Hardware::class,
            'hardware_software',
            'software_asset_id',
            'hardware_asset_id'
        );
    }

    public function softwareType()
    {
        return $this->belongsTo(SoftwareType::class, 'software_type', 'id');
    }

    public function licenseType()
    {
        return $this->belongsTo(LicenseType::class, 'license_type', 'id');
    }

    // Override the getRouteKeyName method
    public function getRouteKeyName()
    {
        return 'asset_id';
    }
}
