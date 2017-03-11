<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HashTag extends Model
{
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_hash_tags', 'post_id', 'hash_tag_id')
            ->withPivot('created_at');
    }
}
