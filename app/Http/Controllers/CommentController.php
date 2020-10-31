<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Article;

class CommentController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function destroy(Comment $comment) {
        $this->authorize('update', $comment);

        $comment->delete();
        return redirect('/articles/'.$comment->article->id);
    }

    public function store(Article $article) {
        $comment = new Comment($this->validateComment());
        $comment->user_id = auth()->user()->id;
        $comment->article_id = $article->id;
        $comment->save();

        return redirect('/articles/'.$comment->article->id);
    }

    public function edit(Comment $comment) {
        $this->authorize('update', $comment);

        return view('comments.edit', ['comment' => $comment]);
    }

    public function update(Comment $comment) {
        $this->authorize('update', $comment);

        $comment->update($this->validateComment());

        return redirect('/articles/'.$comment->article->id);
    }

    protected function validateComment()
    {
        return request()->validate([
            'body'=>['required','min:3'],
        ]);
    }

}
