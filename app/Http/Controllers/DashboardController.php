<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $this->authorize('dashboard', \Auth::user());
        $users = \App\Models\User::all();
        $articles = \App\Models\Article::all();
        $comments = \App\Models\Comment::all();
        return view('dashboard.index',['users' => $users,'articles'=>$articles,'comments'=>$comments]);
    }
}
