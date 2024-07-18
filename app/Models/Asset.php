<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = ['asset_type', 'asset_status', 'brand', 'model'];

    protected $with = ['hardware', 'software']; // Eager load relationships

    public function hardware()
    {
        return $this->hasOne(Hardware::class);
    }

    public function software()
    {
        return $this->hasOne(Software::class);
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function getDetailsAttribute()
    {
        if ($this->asset_type === 'hardware' && $this->hardware) {
            return $this->hardware->specifications;
        } elseif ($this->asset_type === 'software' && $this->software) {
            return $this->software->version;
        }
        return '';
    }
}
