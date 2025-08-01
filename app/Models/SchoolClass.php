<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'grade_level',
        'description',
        'teacher_id'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
