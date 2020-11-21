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
        $users = User::all();
        $tags = Tag::all();
        // $articles = Article::all();
        $articles = Article::orderBy('created_at','desc');

        if (request('tag')) {
            $tag = Tag::where('id', request('tag'))->firstOrFail();
            $articles = $tag->articles;
        }

        if (request('user')) {
            $articles=$articles->where('user_id',request('user'));
        }

        if (request('dateAfter')) {
            $dateAfter = date_create_from_format('Y-m-d', request('dateAfter'));

            $articles = $articles->filter(function ($item) use($dateAfter){
                $dateCreated = date_create_from_format('d/m/Y G:i', $item->created_at);
                return $dateCreated > $dateAfter;
            });
        }

        if (request('dateBefore')) {
            $dateBefore = date_create_from_format('Y-m-d', request('dateBefore'));

            $articles = $articles->filter(function ($item) use($dateBefore){
                $dateCreated = date_create_from_format('d/m/Y G:i', $item->created_at);
                return $dateCreated < $dateBefore;
            });
        }

        if (request('inbody')) {
            $filter = request('inbody');
            
            $articles = $articles->filter(function ($item) use($filter){
                return
                (stristr($item->title, $filter) !== false) ||
                (stristr($item->excerpt, $filter) !== false) ||
                (stristr($item->body, $filter) !== false);
            });
        }

        $articleCount = $articles->count();
        // $articles = $articles->sortByDesc('created_at');
        $articles = $articles->paginate(10);
        $customUri =
            '?user='.request('user').
            '&tag='.request('tag').
            '&dateAfter='.request('dateAfter').
            '&dateBefore='.request('dateBefore');
        $articles->withPath($customUri);

        return view('articles.index',[
            'users'=>$users,
            'tags'=>$tags,
            'articles'=>$articles,
            'articleCount'=>$articleCount,
            'olduser'=>request('user'),
            'oldtag'=>request('tag'),
            'olddateBefore'=>request('dateBefore'),
            'olddateAfter'=>request('dateAfter'),
            'oldinbody'=>request('inbody')]);
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
