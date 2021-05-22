<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function create(Request $req){
        // dd($req->all());
      $comment=[
          'comment'=>$req->comment,
          'article_id'=>$req->articleidd
      ];
      Comment::create($comment);

    }
}
