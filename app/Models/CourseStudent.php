<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseStudent extends Model
{
    /** @use HasFactory<\Database\Factories\CourseStudentFactory> */
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
