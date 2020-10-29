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

<h1>{{$article->title}}</h1>
<p class="font-italic">by: <a href="/articles/?user={{$article->user->id}}">{{$article->user->name}}</a></p> 
<p>{{$article->body}}</p>

<p>
   tags:
   @foreach ($article->tags as $tag)
      {{-- <a href="/articles/?tag={{$tag->name}}">{{$tag->name}}</a> --}}
      <a href="/articles/?tag={{$tag->name}}">{{$tag->name}}</a>
   @endforeach
</p>
@endsection