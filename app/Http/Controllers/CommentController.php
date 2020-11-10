<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Article;
use App\Models\User;

class CommentController extends Controller
{

    public function index() {
        $this->authorize('admin', \Auth::user());
        if (request('user')) {
            $user = User::where('id', request('user'))->firstOrFail();
            $comments = $user->comments;
            $filter = $user->comments->count() . " comments by author: " . $user->name;
        }
        else {
            $comments = Comment::all();
            $filter="";
        }
        $comments = $comments->sortByDesc('created_at');
        return view('comments.index',['comments' => $comments, 'filter'=>$filter]);
    }

    public function destroy(Comment $comment) {
        $this->authorize('update', $comment);

        $comment->delete();
        return redirect('/articles/'.$comment->article->id);
    }

    public function store(Article $article) {
        $this->authorize('loggedIn');
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
