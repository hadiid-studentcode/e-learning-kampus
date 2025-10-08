<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submissions extends Model
{
    /** @use HasFactory<\Database\Factories\SubmissionsFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function assignment()
    {
        return $this->belongsTo(Assignments::class, 'assignment_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
