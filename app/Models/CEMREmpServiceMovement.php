<?php
// File: app/Models/CEMREmpServiceMovement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CEMREmpServiceMovement extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'emp_services_movement';

    protected $fillable = [
        'user_id',
        'id_num',
        'rank_id',
        'emp_stat_id',
        'curr_pos_id',
        'cost_code_id',
        'project_id',
        'division_id',
        'company_id',
        'project_hired_date',
        'comments'
    ];

    protected $casts = [
        'project_hired_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(CEMREmployee::class, 'id_num', 'id_num');
    }

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

    public function costCode()
    {
        return $this->belongsTo(CEMRCostCode::class, 'cost_code_id');
    }

    public function company()
    {
        return $this->belongsTo(CEMRCompany::class, 'company_id');
    }
}
