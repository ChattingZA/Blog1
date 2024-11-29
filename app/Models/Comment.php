<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // A Comment belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A Comment belongs to a Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
