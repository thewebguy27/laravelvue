<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Resources\CommentsResource ;
use App\Http\Resources\Article as ArticleResource;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $articles = Article::get()->toJson(JSON_PRETTY_PRINT);
        // return response($articles, 200);
        // grab articles
        $articles=Article::orderBy('created_at','desc')->paginate(5);
        // return collection as a resource
        return ArticleResource::collection($articles);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Article::create([
            'title'=>$request->title,
            'body'=>$request->body
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get a single article
        $article=Article::findOrFail($id);
        // return single article as a resource
        return new ArticleResource($article);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          //get a single article
          $article=Article::findOrFail($id);
          // return single article as a resource
          if($article->delete()){
            return new ArticleResource($article);
          } 
    }

    public function update(Request $request,$id){
        $article=Article::find($id);
        $article->title=$request->title;
        $article->body=$request->body;

        if($article->save()){
            return new ArticleResource($article);
        }
    }


    public function getComments(Article $article){

        $comments= $article->comments;

        if($comments->isNotEmpty()){
            return  CommentsResource::collection($comments);
        }
        else{
             return response()->json('Not found', 400);
        }
    }
}
