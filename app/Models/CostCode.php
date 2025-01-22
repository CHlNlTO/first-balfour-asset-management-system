<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCode extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'department_project_code', 'description'];

    public function departmentProject()
    {
        return $this->belongsTo(DepartmentProject::class, 'department_project_code', 'code');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'cost_code', 'code');
    }
}
