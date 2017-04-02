<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accusation extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function posts()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
