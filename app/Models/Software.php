<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    use HasFactory;

    protected $primaryKey = 'asset_id'; // Specify the primary key if it's not the default 'id'

    protected $fillable = ['asset_id', 'version', 'license_key', 'software_type', 'license_type'];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function softwareType()
    {
        return $this->belongsTo(SoftwareType::class, 'software_type', 'software_type');
    }

    public function licenseType()
    {
        return $this->belongsTo(LicenseType::class, 'license_type', 'license_type');
    }

    // Override the getRouteKeyName method
    public function getRouteKeyName()
    {
        return 'asset_id';
    }
}
