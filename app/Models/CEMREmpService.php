<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CEMREmpService extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'emp_services';

    public function employees()
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
}
