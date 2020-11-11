<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;

class ArticlesController extends Controller
{

    public function show(Article $article) {
        return view('articles.show', ['article'=>$article]);
    }

    public function index() {
        if (request('tag')) {
            $tag = Tag::where('name', request('tag'))->firstOrFail();
            $articles = $tag->articles;
            $filterType = "tag";
            $filterOn = $tag->name;
        } 
        elseif (request('user')) {
            $user = User::where('id', request('user'))->firstOrFail();
            $articles = $user->articles;
            $filterType = "user";
            $filterOn = $user;
        }
        else {
            $articles = Article::all();
            $filterType = "";
            $filterOn = "";
        }
        $articles = $articles->sortByDesc('created_at');
        $tags = Tag::all();
        $allArticlesCount = Article::all()->count();
        return view('articles.index',[
            'articles' => $articles,
            'tags' => $tags,
            'allArticlesCount' => $allArticlesCount, 
            'filterType' => $filterType, 
            'filterOn' => $filterOn]);
    }

    public function create() {
        $this->authorize('loggedIn');

        // include all Tag data
        return view('articles.create',['tags' => \App\Models\Tag::all()]);
    }

    public function store() {
        $this->authorize('loggedIn');

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
