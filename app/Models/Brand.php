<?php

// app/Models/Brand.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function models(): HasMany
    {
        return $this->hasMany(ProductModel::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
