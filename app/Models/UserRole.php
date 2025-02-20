<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $table = 'model_has_roles';

    protected $fillable = [
        'role_id',
        'model_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
