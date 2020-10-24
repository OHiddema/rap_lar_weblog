@extends('layout')

@section('content')
<a href="/">Home</a>
<h1>All articles:</h1>

@forelse ($articles as $article)
    <h3><a href="/articles/{{$article->id}}">{{ $article->title}}</a></h3>
    <p>{{ $article->excerpt}}</p>
@empty
    <p>There are no articles with this tag!</p>
@endforelse
@endsection