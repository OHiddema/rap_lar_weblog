@extends('layouts.app')

@section('content')

<a class="btn btn-primary" href="/articles">Back</a>
<h3>Advanced article search</h3>
<form action="/search" method="get">

   <div class="form-group">
      <label for="user">Choose an author:</label>
      <select name="user" id="user" class="form-control">
         <option value="0">All users</option>
         @foreach ($users as $user)
            <option value="{{$user->id}}"
            @if ($user->id == $olduser)
               selected
            @endif"
            >{{$user->name}}</option>
         @endforeach
      </select>
   </div>
   
   <div class="form-group">
      <label for="tag">Choose a tag:</label>
      <select name="tag" id="tag" class="form-control">
         <option value="0">All tags</option>
         @foreach ($tags as $tag)
            <option value="{{$tag->id}}"
            @if ($tag->id == $oldtag)
               selected
            @endif"
            >{{$tag->name}}</option>
         @endforeach
      </select> 
   </div>

   <div class="form-group">
      <label for="inbody">Word or phrase in article:</label>
      <input
         type="text"
         name="inbody"
         id="inbody"
         class="form-control"
         value="{{$oldinbody}}">
   </div>

   <div class="container">
      <div class=row>
         <div class="col form-group">
            <label for="dateAfter">Written after:</label>
            <input
               type="date"
               name="dateAfter"
               id="dateAfter"
               class="form-control"
               value="{{$olddateAfter}}">
         </div>
         <div class="col form-group">
            <label for="dateBefore">Written before:</label>
            <input
               type="date"
               name="dateBefore"
               id="dateBefore"
               class="form-control"
               value="{{$olddateBefore}}">
         </div>
      </div>
   </div>

   <button type="submit" class="btn btn-primary mb-4">Submit</button>

</form>

{{-- <h3>Result ({{$articles->count()}} articles):</h3> --}}

@forelse ($articles as $article)
    <div class="container rounded border border-dark mt-2 pl-2 pr-2" style="background-color: rgb(180, 234, 255)">
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

{{$articles->links("pagination::bootstrap-4")}}

@endsection