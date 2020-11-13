@extends('layouts.app')

@section('content')
<a class="btn btn-primary" href="/dashboard/users">All users</a><br>

<table class="table table-sm mt-4">
   <tbody>
      <tr>
         <td>Name:</td>
         <td>{{$user->name}}</td>
      </tr>
      <tr>
         <td>Email:</td>
         <td>{{$user->email}}</td>
      </tr>
      <tr>
         <td>Profile image:</td>
         <td><img class="profile-image" src="{{ $user->image }}"></td>
      </tr>
      <tr>
         <td>Role:</td>
         <td>{{$user->role}}</td>
      </tr>
      <tr>
         <td>Created at:</td>
         <td>{{date_format($user->created_at,"d/m/Y G:i")}}</td>
      </tr>
      <tr>
         <td>Updated at:</td>
         <td>{{date_format($user->updated_at,"d/m/Y G:i")}}</td>
      </tr>
   </tbody>
</table>

<div class="container rounded border border-dark mt-2 pt-2 pb-2" style="background-color: rgb(180, 255, 199)">
   <h5 class="font-weight-bold">This user has:</h5>
<div class="mt-2 mb-2">
   <a class="btn btn-primary btn-sm" href="/articles/?user={{$user->id}}">{{$user->articles->count()}} articles</a>
</div>
<div class="mt-2 mb-2">
   <a class="btn btn-primary btn-sm" href="/comments/?user={{$user->id}}">{{$user->comments->count()}} comments</a>
</div>
<div class="mt-2 mb-2">{{$user->likes->count()}} likes given</div>
<div class="mt-2 mb-2">{{$likes_received}} likes received</div>         
</div>




@endsection