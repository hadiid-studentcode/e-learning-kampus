<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Replies extends Model
{
    /** @use HasFactory<\Database\Factories\RepliesFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function Discussion()
    {
        return $this->belongsTo(Discussions::class, 'discussion_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
