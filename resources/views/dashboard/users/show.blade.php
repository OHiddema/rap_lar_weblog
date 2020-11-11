@extends('layouts.app')

@section('content')
<a class="btn btn-primary" href="/dashboard/users">All users</a><br>

<div class="container rounded border border-dark mt-2 pt-2 pb-2" style="background-color: rgb(180, 234, 255)">
   <div><b>Name: </b>{{$user->name}}</div>
   <div><b>Email: </b>{{$user->email}}</div>
   <div><b>Role: </b>{{$user->role}}</div>
   <div><b>Created at: </b>{{date_format($user->created_at,"d/m/Y G:i")}}</div>
   <div><b>Updated at: </b>{{date_format($user->updated_at,"d/m/Y G:i")}}</div>
</div>

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