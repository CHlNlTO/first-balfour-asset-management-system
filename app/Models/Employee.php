<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'position', 'rank', 'project', 'department', 'employee_status'
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
