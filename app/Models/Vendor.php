<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address_1', 'address_2', 'city', 'tel_no_1', 'tel_no_2', 'contact_person', 'mobile_number', 'email', 'url', 'remarks'];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
