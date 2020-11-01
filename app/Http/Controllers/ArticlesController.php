<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;

class ArticlesController extends Controller
{
    // public function __construct()
    // {(
    //     $this->middleware('auth');
    // }

    public function show(Article $article) {
        return view('articles.show', ['article'=>$article]);
    }

    public function index() {
        if (request('tag')) {
            $tag = Tag::where('name', request('tag'))->firstOrFail();
            // $articles = $tag->articles->sortByDesc('created_at');
            $articles = $tag->articles;
            $filter = $tag->articles->count() . " articles with tag: " . $tag->name;
        } 
        elseif (request('user')) {
            $user = User::where('id', request('user'))->firstOrFail();
            // $articles = $user->articles->sortByDesc('created_at');
            $articles = $user->articles;
            $filter = $user->articles->count() . " articles by author: " . $user->name;
        }
        else {
            // $articles = Article::latest()->get();
            $articles = Article::all();
            $filter="";
        }
        $articles = $articles->sortByDesc('created_at');
        return view('articles.index',['articles' => $articles, 'filter'=>$filter]);
    }

    public function create() {
        // include all Tag data
        return view('articles.create',['tags' => \App\Models\Tag::all()]);
    }

    public function store() {

        $article = new Article($this->validateArticle());
        $article->user_id = auth()->user()->id;
        $article->save();

        $article->tags()->attach(request('tags'));

        return redirect('/articles');
    }

    public function edit(Article $article) {
        $this->authorize('update', $article);

        return view('articles.edit', ['article' => $article, 'tags' => \App\Models\Tag::all()]);
    }

    public function update(Article $article) {
        $this->authorize('update', $article);

        $article->update($this->validateArticle());
        $article->tags()->detach();
        $article->tags()->attach(request('tags'));
        return redirect('/articles/'.$article->id);
    }

    public function destroy(Article $article) {
        $this->authorize('update', $article);

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
