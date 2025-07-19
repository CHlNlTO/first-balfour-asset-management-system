<?php
// File: app/Models/CEMRProject.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CEMRProject extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'projects';

    protected $fillable = [
        'name',
        'company_id'
    ];

    public function empServices()
    {
        return $this->hasMany(CEMREmpService::class, 'project_id');
    }

    public function company()
    {
        return $this->belongsTo(CEMRCompany::class, 'company_id');
    }
}
