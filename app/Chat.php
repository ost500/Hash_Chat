<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function hash_tags()
    {
        return $this->belongsTo(HashTag::class, 'hash_tag_id', 'id');
    }
}
