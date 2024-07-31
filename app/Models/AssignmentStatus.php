<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentStatus extends Model
{
    use HasFactory;

    protected $fillable = ['assignment_status'];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
