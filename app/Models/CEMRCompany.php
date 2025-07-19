<?php
// File: app/Models/CEMRCompany.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CEMRCompany extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'companies';

    protected $fillable = [
        'name'
    ];

    public function employees()
    {
        return $this->belongsToMany(CEMREmployee::class, 'company_user', 'company_id', 'user_id');
    }

    public function ranks()
    {
        return $this->hasMany(CEMRRank::class, 'company_id');
    }

    public function empStatuses()
    {
        return $this->hasMany(CEMRStatus::class, 'company_id');
    }

    public function positions()
    {
        return $this->hasMany(CEMRPosition::class, 'company_id');
    }

    public function costCodes()
    {
        return $this->hasMany(CEMRCostCode::class, 'company_id');
    }

    public function projects()
    {
        return $this->hasMany(CEMRProject::class, 'company_id');
    }

    public function divisions()
    {
        return $this->hasMany(CEMRDivision::class, 'company_id');
    }
}
