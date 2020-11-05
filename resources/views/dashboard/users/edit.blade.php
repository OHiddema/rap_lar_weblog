@extends('layouts.app')

@section('content')
   <h1>Edit user</h1>
   <form action="/dashboard/users/{{$user->id}}" method="post">
      @csrf
      @method('PUT')
   
      <div class="form-group">
         <label for="name">Name</label>
         <input
            type="text"
            name="name"
            id="name"
            class="form-control"
            value="{{old('name',$user->name)}}">
            @error('name')
               <p class="alert alert-danger">{{$errors->first('name')}}</p>
            @enderror
      </div>
   
      <div class="form-group">
         <label for="email">Email</label>
         <input
            type="email"
            name="email"
            id="email"
            class="form-control"
            value="{{old('email',$user->email)}}">
            @error('email')
               <p class="alert alert-danger">{{$errors->first('email')}}</p>
            @enderror
      </div>
      
      <div class="form-group">
         <label for="role">Role</label><br>
         <input type="radio" id="user" name="role" value="user" @if ($user->role == 'user')
             checked
         @endif>
         <label for="user">user</label><br>
         <input type="radio" id="admin" name="role" value="admin" @if ($user->role == 'admin')
             checked
         @endif>
         <label for="admin">admin</label><br>       
      </div>

      <button class="btn btn-primary mt-2" type="submit">Submit</button>
   </form>

@endsection