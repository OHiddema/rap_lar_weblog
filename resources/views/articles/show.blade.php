@extends('layout')

@section('content')
<button><a href="/articles">Back to list off articles</a></button><br>
<button><a href="/articles/{{$article->id}}/edit">Edit article</a></button>
<h1>{{$article->title}}</h1>
<p>{{$article->body}}</p>

<p>
   @foreach ($article->tags as $tag)
      {{-- <a href="/articles/?tag={{$tag->name}}">{{$tag->name}}</a> --}}
      <a href="/articles/?tag={{$tag->name}}">{{$tag->name}}</a>
   @endforeach
</p>
@endsection