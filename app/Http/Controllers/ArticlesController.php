<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Article $article) {
        return view('articles.show', ['article'=>$article]);
    }

    public function index() {
        if (request('tag')) {
            $articles = Tag::where('name', request('tag'))->firstOrFail()->articles;
            $filter = "with tag: " . Tag::where('name', request('tag'))->firstOrFail()->name;
        } 
        elseif (request('user')) {
            $articles = User::where('id', request('user'))->firstOrFail()->articles;
            $filter = "by author: " . User::where('id', request('user'))->firstOrFail()->name;
        }
        else {
            $articles = Article::latest()->get();
            $filter="";
        }
        return view('articles.index',['articles' => $articles, 'filter'=>$filter]);
    }

    public function create() {
        // include all Tag data
        return view('articles.create',['tags' => \App\Models\Tag::all()]);
    }

    public function store() {

        // because we have no authentication yet, we don't have an author,
        // so we cannot use create yet, so we create author manually
        // Article::create($this->validateArticle());
        $article = new Article($this->validateArticle());
        // $article->user_id = 1;
        $article->user_id = auth()->user()->id;
        $article->save();

        $article->tags()->attach(request('tags'));

        return redirect('/articles');
    }

    public function edit(Article $article) {
        return view('articles.edit', ['article' => $article, 'tags' => \App\Models\Tag::all()]);
    }

    public function update(Article $article) {
        $article->update($this->validateArticle());
        $article->tags()->detach();
        $article->tags()->attach(request('tags'));
        return redirect('/articles/'.$article->id);
    }

    public function destroy(Article $article) {
        $article->delete();
        return redirect('/articles');
    }

    protected function validateArticle()
    {
        return request()->validate([
            'title'=>['required','min:3','max:255'],
            'excerpt'=>['required','min:3'],
            'body'=>['required','min:3']
        ]);
    }
}
