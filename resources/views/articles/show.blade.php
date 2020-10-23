@extends('layout')

@section('content')
<a href="/articles">Back to list off articles</a>
<h1>{{$article->title}}</h1>
<p>{{$article->body}}</p>
@endsection