<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenseType extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; // Ensure this matches the actual primary key column name
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['license_type'];

    public function software()
    {
        return $this->hasMany(Software::class, 'license_type', 'id');
    }
}
