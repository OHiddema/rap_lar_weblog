@extends('layouts.app')

@section('content')
   @can('admin', Auth::user())
      <h1>Users</h1>
      <table class="table table-sm">
         <thead class="thead-light">
            <tr>
               <th>Name</th>
               <th>Email</th>
               <th>Role</th>
               <th></th>
            </tr>
         </thead>
         <tbody>
            @foreach ($users as $user)
               <tr>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->role}}</td>
                  <td>
                     <a class="btn btn-primary btn-sm" href="/dashboard/users/{{$user->id}}">Show</a>
                     <a class="btn btn-primary btn-sm" href="/dashboard/users/{{$user->id}}/edit">Edit</a>
                     <div class="d-inline-block">
                        <form action="/dashboard/users/{{$user->id}}" method="POST">
                           @csrf
                           @method('DELETE')
                           <button class="btn btn-danger btn-sm" type="submit" title="delete">Delete</button>
                        </form>
                     </div>
                  </td>            
               </tr>
            @endforeach
         </tbody>
      </table>
   @endcan
@endsection
