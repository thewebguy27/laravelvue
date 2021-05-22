<?php

namespace App;

use App\Comment;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded=[];

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
