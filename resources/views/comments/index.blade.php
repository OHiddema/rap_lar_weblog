@extends('layouts.app')

@section('content')
<div>
    {{-- <div class="d-inline-block">
        @auth
            <a class="btn btn-primary" href="/articles/create">Create new article</a>
        @endauth
    </div> --}}
    <div class="d-inline-block">
        <a class="btn btn-primary" href="/comments">All comments</a>
    </div>
</div>
@if ($filter=="")
    <h1>All comments ({{$comments->count()}})</h1>
@else
    <h1>{{$filter}}</h1>
@endif

@forelse ($comments as $comment)
    <div class="container rounded border border-dark mb-2 pb-1" style="background-color: rgb(180, 234, 255)">
        {{-- <div class="font-weight-bold">{{date_format($comment->created_at,"d/m/Y G:i")}}</div> --}}
        <div class="font-weight-bold">{{$comment->created_at}}</div>
        <div>{{ $comment->body}}</div>

        @if (request('user'))
            <a class="btn btn-primary btn-sm" href="/comments/{{$comment->id}}/edit/?user={{request('user')}}">Edit</a>            
        @else
            <a class="btn btn-primary btn-sm" href="/comments/{{$comment->id}}/edit">Edit</a>        
        @endif

        <div class="d-inline-block">

        @if (request('user'))
            <form action="/comments/{{$comment->id}}/?user={{request('user')}}" method="POST">
        @else
            <form action="/comments/{{$comment->id}}" method="POST">
        @endif
      
              @csrf
              @method('DELETE')
              <button class="btn btn-danger btn-sm" type="submit" title="delete">Delete</button>
           </form>
        </div>

        <a class="btn btn-primary btn-sm" href="/articles/{{$comment->article->id}}">View article</a>
    </div>
@empty
    <p>No comments found!</p>
@endforelse
@endsection