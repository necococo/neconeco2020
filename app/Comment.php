<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['micropost_id', 'comment', 'user_id'];

    public function micropost()
    {
        return $this->belongsTo(Micropost::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
