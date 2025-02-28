<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'id_number',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'full_name',
        'microsoft',
        'gmail',
        'rank_and_file',
        'employment_status',
        'current_position',
        'cost_code',
        'project_division_department',
        'division',
        'cbe'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id_num', 'id_number');
    }

    public function costCode()
    {
        return $this->belongsTo(CostCode::class, 'cost_code');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'employee_id', 'id_number');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
