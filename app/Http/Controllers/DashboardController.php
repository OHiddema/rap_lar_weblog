<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function index(){
        $this->authorize('dashboard', \Auth::user());
        $users = \App\Models\User::all();
        $articles = \App\Models\Article::all();
        $comments = \App\Models\Comment::all();
        $roles = $users->pluck('role')->countBy();

        $articles_per_user = DB::table('articles')
            ->join('users', 'users.id', '=', 'articles.user_id')
            ->select('users.name','articles.id')
            ->pluck('users.name')->countBy();            

        $comments_per_user = DB::table('comments')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->select('users.name','comments.id')
            ->pluck('users.name')->countBy();            

        return view('dashboard.index',
            ['users' => $users,
            'articles' => $articles,
            'comments' => $comments,
            'roles' => $roles,
            'articles_per_user' => $articles_per_user,
            'comments_per_user' => $comments_per_user
            ]);
    }
}
