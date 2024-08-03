<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = ['asset_type', 'asset_status', 'brand', 'model'];

    protected $with = ['hardware', 'software', 'peripherals', 'lifecycle', 'purchases', 'assetStatus']; // Eager load relationships

    public function hardware()
    {
        return $this->hasOne(Hardware::class);
    }
    public function software()
    {
        return $this->hasOne(Software::class);
    }

    public function peripherals()
    {
        return $this->hasOne(Peripheral::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function lifecycle()
    {
        return $this->hasOne(Lifecycle::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function assetStatus()
    {
        return $this->belongsTo(AssetStatus::class, 'asset_status', 'id');
    }
    public function getDetailsAttribute()
    {
        if ($this->asset_type === 'hardware' && $this->hardware) {
            return $this->hardware->specifications;
        } elseif ($this->asset_type === 'software' && $this->software) {
            return $this->software->version;
        } else if ($this->asset_type === 'peripherals' && $this->peripherals) {
            return $this->peripherals->specifications;
        }
        return '';
    }
}
