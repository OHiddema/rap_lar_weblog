<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DB;

class UsersController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('admin', \Auth::user());

        $likes_received = DB::table('likes')
            ->join('articles', 'likes.article_id', '=', 'articles.id')
            ->where('articles.user_id','=',$user->id)
            ->pluck('likes.id')
            ->count();

        return view('dashboard.users.show',['user' => $user, 'likes_received' => $likes_received]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('admin', \Auth::user());
        $users = \App\Models\User::all();
        return view('dashboard.users.index',['users' => $users]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('admin', \Auth::user());
        return view('dashboard.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('admin', \Auth::user());
        $user->update($this->validateUser());
        return redirect('/dashboard/users/');
    }

    protected function validateUser()
    {
        return request()->validate([
            'name'=>['required','min:3','max:32'],
            'email'=>['required','min:3','max:32'],
            'role'=>['required']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('admin', \Auth::user());
        $user->delete();
        return redirect('/dashboard/users');
    }

}
