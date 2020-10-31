@extends('layouts.app')

@section('content')
<button><a href="/home">Home</a></button><br>
@auth
    <button><a href="/articles/create">Create new article</a></button>
@endauth
<h1>All articles {{$filter}}</h1>

@forelse ($articles as $article)
    <div class="container rounded border border-dark m-1" style="background-color: rgb(180, 234, 255)">
        <h3><a href="/articles/{{$article->id}}">{{ $article->title}}</a></h3>
        <p class="font-italic mt-0 mb-0">Written by: <a href="/articles/?user={{$article->author->id}}">{{$article->author->name}}</a>, on: {{date_format($article->created_at,"d/m/Y")}}</p> 
        <p class="font-italic mt-0 mb-0">
        tags:
        @foreach ($article->tags as $tag)
            <a href="/articles/?tag={{$tag->name}}">{{$tag->name}}</a>
        @endforeach
        </p>

        <p class="mt-2">{{ $article->excerpt}}</p>
    </div>
@empty
    <p>No articles found!</p>
@endforelse
@endsection