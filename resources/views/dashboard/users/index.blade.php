@extends('layouts.app')

@section('content')
   @can('admin', Auth::user())
      <h1>Users</h1>
      <div class="container">
         <div class="row border">
            <div class="col-3 border font-weight-bold">
               Name
            </div>
            <div class="col-3 border border font-weight-bold">
               Email
            </div>
            <div class="col-1 border border font-weight-bold">
               Role
            </div>
            {{-- <div class="col-3 border border font-weight-bold">
               Created_at
            </div> --}}
            <div class="col-5 border border font-weight-bold">
            </div>
         </div>
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
               {{-- <div class="col-3 border">
                  {{date_format($user->created_at,"d/m/Y G:i:s")}}
               </div> --}}
               <div class="col-5 border">
                  <a class="btn btn-primary btn-sm" href="/dashboard/users/{{$user->id}}">Show</a>
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
