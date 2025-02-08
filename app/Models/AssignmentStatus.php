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

    public function assignmentStatus()
    {
        return $this->belongsTo(AssignmentStatus::class, 'assignment_status', 'id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function getColor()
    {
        return $this->color->name ?? 'gray';
    }
}
