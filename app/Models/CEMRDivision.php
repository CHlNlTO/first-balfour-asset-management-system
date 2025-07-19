<?php
// File: app/Models/CEMRDivision.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CEMRDivision extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'divisions';

    protected $fillable = [
        'name',
        'division_head',
        'division_head_name',
        'company_id'
    ];

    public function empServices()
    {
        return $this->hasMany(CEMREmpService::class, 'division_id');
    }

    public function company()
    {
        return $this->belongsTo(CEMRCompany::class, 'company_id');
    }

    public function divisionHead()
    {
        return $this->belongsTo(CEMREmployee::class, 'division_head');
    }
}
