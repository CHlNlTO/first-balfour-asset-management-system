<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CEMREmployee extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'employees';

    public function testConnection()
    {
        return DB::connection($this->connection)->table($this->table)->get();
    }

    public function empService()
    {
        return $this->hasOne(CEMREmpService::class, 'id_num', 'id_num');
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

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getRouteKeyName()
    {
        return 'id_num';
    }
}
