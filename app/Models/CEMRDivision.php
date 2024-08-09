<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CEMRDivision extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'divisions';


    public function empServices()
    {
        return $this->hasMany(CEMREmpService::class, 'division_id');
    }
}
