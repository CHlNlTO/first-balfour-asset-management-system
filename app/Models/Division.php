<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'description'];

    public function departmentProjects()
    {
        return $this->hasMany(DepartmentProject::class, 'division_code', 'code');
    }
}
