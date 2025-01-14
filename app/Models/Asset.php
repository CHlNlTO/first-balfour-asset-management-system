<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = ['asset_type', 'asset_status', 'model_id', 'department_project_code', 'tag_number'];

    protected $with = ['hardware', 'software', 'peripherals', 'lifecycle', 'purchases', 'assetStatus', 'model']; // Eager load relationships

    public function brand()
    {
        return $this->model->belongsTo(Brand::class, ProductModel::class);
    }

    public function model()
    {
        return $this->belongsTo(ProductModel::class);
    }

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

    public function installedSoftware()
    {
        return $this->hasManyThrough(
            Software::class,
            HardwareSoftware::class,
            'hardware_asset_id', // Foreign key on hardware_software
            'asset_id', // Foreign key on software
            'id', // Local key on hardware
            'software_asset_id' // Local key on pivot
        );
    }

    public function installedHardware()
    {
        return $this->hasManyThrough(
            Hardware::class,
            HardwareSoftware::class,
            'software_asset_id', // Foreign key on hardware_software
            'asset_id', // Foreign key on hardware
            'id', // Local key on assets
            'hardware_asset_id' // Local key on pivot
        );
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

    public function getAssetAttribute(): ?string
    {
        if (!$this->model || !$this->model->brand) {
            return null;
        }

        return "{$this->model->brand->name} {$this->model->name}";
    }
}
