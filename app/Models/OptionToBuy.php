<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OptionToBuy extends Model
{
    use HasFactory;

    protected $table = 'option_to_buy';

    protected $fillable = [
        'assignment_id',
        'asset_cost',
        'option_to_buy_status',
        'document_path',
    ];

    protected $appends = [
        'document_url',
    ];

    protected static function boot()
    {
        parent::boot();

        // Delete the file when the record is deleted
        static::deleting(function ($model) {
            if ($model->document_path) {
                Storage::disk('public')->delete($model->document_path);
            }
        });
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function status()
    {
        return $this->belongsTo(AssignmentStatus::class, 'option_to_buy_status');
    }

    public function getDocumentUrlAttribute()
    {
        if (!$this->document_path) {
            return null;
        }

        return url('storage/' . $this->document_path);
    }
}
