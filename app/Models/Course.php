<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_name',
        'course_code',

    ];

    use HasFactory;
    protected $table = 'courses';

/**
 * Get all of the grammers for the Course
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function grammers()
{
    return $this->hasMany(Grammer::class);
}
/**
 * Get all of thn exam for the Course
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function exam()
{
    return $this->hasMany(Exam::class);
}
}
