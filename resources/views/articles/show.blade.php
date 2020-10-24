@extends('layout')

@section('content')
<a href="/articles">Back to list off articles</a>
<h1>{{$article->title}}</h1>
<p>{{$article->body}}</p>

<p>
   @foreach ($article->tags as $tag)
      {{-- <a href="/articles/?tag={{$tag->name}}">{{$tag->name}}</a> --}}
      <a href="/articles/?tag={{$tag->name}}">{{$tag->name}}</a>
   @endforeach
</p>
@endsection