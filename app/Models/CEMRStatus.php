<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CEMRStatus extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'emp_statuses';

    public function empServices()
    {
        return $this->hasMany(CEMREmpService::class, 'emp_stat_id');
    }
}
