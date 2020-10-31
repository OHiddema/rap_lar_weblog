@extends('layouts.app')

@section('content')
<div>
    <div class="d-inline-block">
        @auth
            <a class="btn btn-primary" href="/articles/create">Create new article</a>
        @endauth
    </div>
    <div class="d-inline-block">
        <a class="btn btn-primary" href="/articles">All articles</a>
    </div>
</div>
@if ($filter=="")
    <h1>All articles ({{$articles->count()}})</h1>
@else
    <h1>{{$filter}}</h1>   
@endif

@forelse ($articles as $article)
    <div class="container rounded border border-dark m-1" style="background-color: rgb(180, 234, 255)">
        <h3><a href="/articles/{{$article->id}}">{{ $article->title}}</a></h3>
        <p class="font-italic mt-0 mb-0">
            Written by: 
            <a href="/articles/?user={{$article->author->id}}">{{$article->author->name}}</a>
            , on: {{date_format($article->created_at,"d/m/Y G:i")}}</p> 
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