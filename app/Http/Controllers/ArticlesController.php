<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticlesController extends Controller
{
    public function show(Article $article) {
        return view('articles.show', ['article'=>$article]);
    }

    public function index() {
        $articles = Article::latest()->get();
        return view('articles.index',['articles' => $articles]);
    }

    public function create() {
        return view('articles.create');
    }

    public function store() {

        Article::create($this->validateArticle());

        return redirect('/articles');
    }

    public function edit(Article $article) {
        return view('articles.edit', compact('article'));
    }

    public function update(Article $article) {

        $article->update($this->validateArticle());

        return redirect('/articles/'.$article->id);
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