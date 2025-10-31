<?php
// File: app/Models/CEMREmployee.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CEMREmployee extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'employees';

    protected $fillable = [
        'id_num',
        'first_name',
        'middle_name',
        'last_name',
        'suffix_name',
        'birthdate',
        'city',
        'sex',
        'email',
        'cbe',
        'active',
        'manager_id',
        'supervisor_id',
        'original_hired_date',
        'final_attrition_date',
        'avatar'
    ];

    protected $casts = [
        'birthdate' => 'date',
        'original_hired_date' => 'date',
        'final_attrition_date' => 'date',
        'cbe' => 'boolean',
        'active' => 'boolean'
    ];

    public function testConnection()
    {
        return DB::connection($this->connection)->table($this->table)->get();
    }

    public function empService()
    {
        return $this->hasOne(CEMREmpService::class, 'id_num', 'id_num');
    }

    public function empServiceMovements()
    {
        return $this->hasMany(CEMREmpServiceMovement::class, 'id_num', 'id_num');
    }

    public function manager()
    {
        return $this->belongsTo(CEMREmployee::class, 'manager_id', 'id');
    }

    public function supervisor()
    {
        return $this->belongsTo(CEMREmployee::class, 'supervisor_id', 'id');
    }

    public function managedEmployees()
    {
        return $this->hasMany(CEMREmployee::class, 'manager_id', 'id');
    }

    public function supervisedEmployees()
    {
        return $this->hasMany(CEMREmployee::class, 'supervisor_id', 'id');
    }

    public function companies()
    {
        return $this->belongsToMany(CEMRCompany::class, 'company_user', 'user_id', 'company_id');
    }

    // Legacy relationships for direct access (if emp_services data is stored directly on employees table)
    public function rank()
    {
        return $this->belongsTo(CEMRRank::class, 'rank_id');
    }

    public function position()
    {
        return $this->belongsTo(CEMRPosition::class, 'curr_pos_id');
    }

    public function project()
    {
        return $this->belongsTo(CEMRProject::class, 'project_id');
    }

    public function division()
    {
        return $this->belongsTo(CEMRDivision::class, 'division_id');
    }

    public function status()
    {
        return $this->belongsTo(CEMRStatus::class, 'emp_stat_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'employee_id', 'id_num');
    }

    public function getFullNameAttribute()
    {
        return trim(
            $this->first_name . ' ' .
            ($this->middle_name ? $this->middle_name . ' ' : '') .
            $this->last_name .
            ($this->suffix_name ? ' ' . $this->suffix_name : '')
        );
    }
}
