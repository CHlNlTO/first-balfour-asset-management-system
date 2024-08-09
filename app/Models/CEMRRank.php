<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CEMRRank extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'ranks';

    public function empServices()
    {
        return $this->hasMany(CEMREmpService::class, 'rank_id');
    }
}
