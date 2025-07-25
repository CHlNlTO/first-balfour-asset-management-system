<?php
// File: app/Models/CEMRStatus.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CEMRStatus extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'emp_statuses';

    protected $fillable = [
        'name',
        'company_id'
    ];

    public function empServices()
    {
        return $this->hasMany(CEMREmpService::class, 'emp_stat_id');
    }

    public function company()
    {
        return $this->belongsTo(CEMRCompany::class, 'company_id');
    }
}
