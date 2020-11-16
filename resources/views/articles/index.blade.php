@extends('layouts.app')

@section('content')

    <div class="mb-2">
        @auth
            <a class="btn btn-primary" href="/articles/create">Create new article</a>
        @endauth
        <a class="btn btn-primary" href="/search">Advanced search</a>
    </div>
    <div class="p-2 mb-2 border border-dark rounded" style="background-color: rgb(180, 255, 199)">
        <div class="d-inline-block mr-2">Filter:</div>
        <div class="d-inline-block">
            <div class="d-inline-block mr-2">
                <a class="btn @if ($filterType == "")
                    btn-success
                @else
                    btn-primary
                @endif 
                btn-sm" href="/articles">All articles ({{$allArticlesCount}})</a>
            </div>
            <div class="d-inline-block mr-2">
                @foreach ($tags as $tag)
                    <a class="btn @if ($filterType == "tag" && $filterOn == $tag->name)
                        btn-success
                    @else
                        btn-primary
                    @endif 
                    btn-sm" href="/articles/?tag={{$tag->name}}">{{$tag->name}} ({{$tag->articles->count()}})</a>        
                @endforeach
            </div>
            <div class="d-inline-block">
                @if ($filterType == "user")
                    <button class="btn btn-sm btn-success" disabled="disabled">{{$filterOn->name}} ({{$filterOn->articles->count()}})</button>
                @endif
            </div>
        </div>            
    </div>

@forelse ($articles as $article)
    <div class="container rounded border border-dark mb-2 pl-2 pr-2" style="background-color: rgb(180, 234, 255)">
        <h3><a href="/articles/{{$article->id}}">{{ $article->title}}</a></h3>
        <p class="font-italic mt-0 mb-0">
            Written by: 
            <a href="/articles/?user={{$article->author->id}}">{{$article->author->name}}</a>
            , on: {{$article->created_at}}</p> 
        <p class="font-italic mt-0 mb-0">
        tags:
        @foreach ($article->tags as $tag)
            <a href="/articles/?tag={{$tag->name}}">{{$tag->name}}</a>
        @endforeach
        </p>

        <p class="mt-2 mb-1">{{ $article->excerpt}}</p>
    </div>
@empty
    <p>No articles found!</p>
@endforelse

@endsection