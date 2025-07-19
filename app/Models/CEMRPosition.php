<?php
// File: app/Models/CEMRPosition.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CEMRPosition extends Model
{
    protected $connection = 'central_employeedb';
    protected $table = 'current_positions';

    protected $fillable = [
        'name',
        'company_id'
    ];

    public function empServices()
    {
        return $this->hasMany(CEMREmpService::class, 'curr_pos_id');
    }

    public function company()
    {
        return $this->belongsTo(CEMRCompany::class, 'company_id');
    }
}
