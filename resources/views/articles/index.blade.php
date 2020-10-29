@extends('layouts.app')

@section('content')
<button><a href="/home">Home</a></button><br>
<button><a href="/articles/create">Create new article</a></button>
<h1>All articles {{$filter}}</h1>

@forelse ($articles as $article)
    <div style="background-color: rgb(199, 239, 255)">
    <h3><a href="/articles/{{$article->id}}">{{ $article->title}}</a></h3>
    <p class="font-italic">by: <a href="/articles/?user={{$article->user->id}}">{{$article->user->name}}</a></p> 
    <p>{{ $article->excerpt}}</p>
    </div>
@empty
    <p>No articles found!</p>
@endforelse
@endsection