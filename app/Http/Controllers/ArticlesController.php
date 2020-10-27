<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;

class ArticlesController extends Controller
{
    public function show(Article $article) {
        return view('articles.show', ['article'=>$article]);
    }

    public function index() {
        if (request('tag')) {
            $articles = Tag::where('name', request('tag'))->firstOrFail()->articles;
        } else {
            $articles = Article::latest()->get();
        }
        return view('articles.index',['articles' => $articles]);
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
        $article->user_id = 1;
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
