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
        return $this->belongsToMany(HashTag::class,
            'post_hash_tags', 'post_id', 'hash_tag_id')
            ->withPivot('created_at');
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
