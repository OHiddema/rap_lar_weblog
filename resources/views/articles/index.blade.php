{{-- @extends('layout') --}}
@extends('layouts.app')

@section('content')
<button><a href="/home">Home</a></button><br>
<button><a href="/articles/create">Create new article</a></button>
<h1>All articles:</h1>

@forelse ($articles as $article)
    <h3><a href="/articles/{{$article->id}}">{{ $article->title}}</a></h3>
    <p>{{ $article->excerpt}}</p>
@empty
    <p>There are no articles with this tag!</p>
@endforelse
@endsection