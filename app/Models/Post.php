<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', // Add this line
        'title',
        'content',
    ];

    // A Post belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A Post has many Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
