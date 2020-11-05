<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\Like;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function destroy(Article $article) {
        // $this->authorize('update', $comment);

        // haal de like met article_id en user_id van auth user
        $like = Like::where([['article_id', $article->id],['user_id', auth()->user()->id]])->firstOrFail();

        $like->delete();
        return redirect('/articles/'.$like->article->id);
    }

    public function store(Article $article) {
        $like = new Like();
        $like->user_id = auth()->user()->id;
        $like->article_id = $article->id;
        $like->save();

        return redirect('/articles/'.$like->article->id);
    }
}
