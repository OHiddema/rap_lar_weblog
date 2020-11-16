<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;

class ArticlesController extends Controller
{

    public function search() {
        $users = User::all();
        $tags = Tag::all();
        $articles = Article::all();

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
                return stristr($item->body, $filter) !== false;
            });
        }

        $articles = $articles->sortByDesc('created_at');
        $articles = $articles->paginate(3);
        $customUri =
            '?user='.request('user').
            '&tag='.request('tag').
            '&dateAfter='.request('dateAfter').
            '&dateBefore='.request('dateBefore');
        $articles->withPath($customUri);

        return view('search',[
            'users'=>$users,
            'tags'=>$tags,
            'articles'=>$articles,
            'olduser'=>request('user'),
            'oldtag'=>request('tag'),
            'olddateBefore'=>request('dateBefore'),
            'olddateAfter'=>request('dateAfter'),
            'oldinbody'=>request('inbody')]);
    }

    public function show(Article $article) {
        return view('articles.show', ['article'=>$article]);
    }

    public function index() {
        if (request('tag')) {
            $tag = Tag::where('name', request('tag'))->firstOrFail();
            $articles = $tag->articles;
            $filterType = "tag";
            $filterOn = $tag->name;
            $customUri = "?tag=".request('tag');
        } 
        elseif (request('user')) {
            $user = User::where('id', request('user'))->firstOrFail();
            $articles = $user->articles;
            $filterType = "user";
            $filterOn = $user;
            $customUri = "?user=".request('user');
        }
        else {
            $articles = Article::all();
            $filterType = "";
            $filterOn = "";
            $customUri = "";
        }
        $articles = $articles->sortByDesc('created_at');
        $articles = $articles->paginate(3);
        $articles->withPath($customUri);
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
