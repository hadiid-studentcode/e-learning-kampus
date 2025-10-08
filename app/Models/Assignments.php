<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignments extends Model
{
    /** @use HasFactory<\Database\Factories\AssignmentsFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }
}
