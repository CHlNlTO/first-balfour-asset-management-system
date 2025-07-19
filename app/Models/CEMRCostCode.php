<?php
// File: app/Models/CEMRCostCode.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CEMRCostCode extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'cost_codes';

    protected $fillable = [
        'name',
        'location',
        'company_id'
    ];

    public function empServices()
    {
        return $this->hasMany(CEMREmpService::class, 'cost_code_id');
    }

    public function company()
    {
        return $this->belongsTo(CEMRCompany::class, 'company_id');
    }
}
