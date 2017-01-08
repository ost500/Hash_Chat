<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function hash_tags()
    {
        return $this->belongsTo(HashTag::class, 'hash_tag_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

}
