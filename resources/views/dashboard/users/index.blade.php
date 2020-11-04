@extends('layouts.app')

@section('content')
   @can('admin', Auth::user())
      <h1>Users</h1>
      <div class="container">
         @foreach ($users as $user)
            <div class="row border">
               <div class="col-3 border">
                  {{$user->name}}
               </div>
               <div class="col-3 border">
                  {{$user->email}}
               </div>
               <div class="col-1 border">
                  {{$user->role}}
               </div>
               <div class="col-3 border">
                  {{date_format($user->created_at,"d/m/Y G:i:s")}}
               </div>
               <div class="col-2 border">
                  <a class="btn btn-primary btn-sm" href="/dashboard/users/{{$user->id}}/edit">Edit</a>
                  <div class="d-inline-block">
                     <form action="/dashboard/users/{{$user->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit" title="delete">Delete</button>
                     </form>
                  </div>
               </div>
           </div>
         @endforeach
      </div>
   @endcan
@endsection
