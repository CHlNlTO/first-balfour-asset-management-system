<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeripheralType extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'peripherals_types';

    protected $fillable = ['peripherals_type'];

    public function peripherals()
    {
        return $this->hasMany(Peripheral::class);
    }
}
