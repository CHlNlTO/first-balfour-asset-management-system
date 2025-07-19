<?php
// File: app/Models/CEMRRank.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CEMRRank extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'ranks';

    protected $fillable = [
        'name',
        'company_id'
    ];

    public function empServices()
    {
        return $this->hasMany(CEMREmpService::class, 'rank_id');
    }

    public function company()
    {
        return $this->belongsTo(CEMRCompany::class, 'company_id');
    }
}
