<?php

// app/Models/PCName.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PCName extends Model
{
    use HasFactory;

    protected $table = 'pc_names';

    protected $fillable = [
        'name',
        'description',
    ];

    public function hardware(): HasMany
    {
        return $this->hasMany(Hardware::class);
    }

    public function software()
    {
        return $this->hasMany(Software::class);
    }
}
