<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'credits',
        'teacher_id'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
