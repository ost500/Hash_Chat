<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostHashTag extends Model
{
    public function hash_tags()
    {
        return $this->belongsTo(HashTag::class, 'hash_tag_id');
    }

    public function posts()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

}
