<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentProject extends Model
{
    use HasFactory;

    protected $table = 'departments_projects';

    protected $fillable = ['code', 'name', 'division_code', 'description'];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_code', 'code');
    }

    public function costCodes()
    {
        return $this->hasMany(CostCode::class, 'department_project_code', 'code');
    }
}
