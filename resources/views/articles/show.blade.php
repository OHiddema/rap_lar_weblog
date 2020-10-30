@extends('layouts.app')

@section('content')
<button><a href="/articles">Back to list off articles</a></button><br>
<button><a href="/articles/{{$article->id}}/edit">Edit article</a></button>

<form action="/articles/{{$article->id}}" method="POST">
   @csrf
   @method('DELETE')
   <button type="submit" title="delete">
       <i class="fas fa-trash fa-lg text-danger">Delete article</i>
   </button>
</form>

<div class="container rounded border border-dark pb-2 mt-2" style="background-color: rgb(180, 234, 255)">
   <h1>{{$article->title}}</h1>
   <p class="m-0">by: <a href="/articles/?user={{$article->user->id}}">{{$article->user->name}}</a></p> 
   <p class="m-0">
      tags:
      @foreach ($article->tags as $tag)
         <a href="/articles/?tag={{$tag->name}}">{{$tag->name}}</a>
      @endforeach
   </p>
   <p class="mt-2">{{$article->body}}</p>
  
   @foreach ($article->comments as $comment)
      <div class="container rounded border border-dark mt-2" style="background-color: rgb(180, 255, 199)">
      <p>{{$comment->user->name}}, {{ date_format($comment->created_at,"d/m/Y G:i")}}</p>
         <p>{{$comment->body}}</p>
      </div>
   @endforeach
</div>

@endsection