<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CEMRProject extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'projects';

    public function empServices()
    {
        return $this->hasMany(CEMREmpService::class, 'project_id');
    }
}
