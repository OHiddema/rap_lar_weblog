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
   <p>This user has:</p>
<div>{{$user->articles->count()}} articles written
   <a class="btn btn-primary btn-sm" href="/articles/?user={{$user->id}}">Show articles</a>
</div>
<div>{{$user->comments->count()}} comments written</div>
<div>{{$user->likes->count()}} likes given</div>
<div>{{$likes_received}} likes received</div>         
</div>




@endsection