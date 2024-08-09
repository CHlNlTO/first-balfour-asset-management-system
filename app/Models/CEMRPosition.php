<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CEMRPosition extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'current_positions';

    public function empServices()
    {
        return $this->hasMany(CEMREmpService::class, 'curr_pos_id');
    }
}
