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
        return $this->hasMany(Post::class);
    }
}
