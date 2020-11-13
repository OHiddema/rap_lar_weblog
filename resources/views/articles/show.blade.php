@extends('layouts.app')

@section('content')
<a class="btn btn-primary" href="/articles">All articles</a><br>

<div class="container rounded border border-dark pb-2 mt-2" style="background-color: rgb(180, 234, 255)">
   <h1>{{$article->title}}</h1>
   <p class="m-0"><a href="/articles/?user={{$article->author->id}}">
      @if ($article->author->image)
         <img class="profile-image" src="{{ $article->author->image }}">
      @endif
      {{$article->author->name}}</a></p> 
   <p class="m-0">
      tags:
      @foreach ($article->tags as $tag)
         <a href="/articles/?tag={{$tag->name}}">{{$tag->name}}</a>
      @endforeach
   </p>
   <p class="mt-2">{{$article->body}}</p>

   <div class="container">
      <div class="row">
         <div class="col-6">
            <div>
               <div class="d-inline-block font-weight-bold ml-2">{{$article->likes->count()}}</div>
               <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-hand-thumbs-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16v-1c.563 0 .901-.272 1.066-.56a.865.865 0 0 0 .121-.416c0-.12-.035-.165-.04-.17l-.354-.354.353-.354c.202-.201.407-.511.505-.804.104-.312.043-.441-.005-.488l-.353-.354.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581 0-.211-.027-.414-.075-.581-.05-.174-.111-.273-.154-.315L12.793 9l.353-.354c.353-.352.373-.713.267-1.02-.122-.35-.396-.593-.571-.652-.653-.217-1.447-.224-2.11-.164a8.907 8.907 0 0 0-1.094.171l-.014.003-.003.001a.5.5 0 0 1-.595-.643 8.34 8.34 0 0 0 .145-4.726c-.03-.111-.128-.215-.288-.255l-.262-.065c-.306-.077-.642.156-.667.518-.075 1.082-.239 2.15-.482 2.85-.174.502-.603 1.268-1.238 1.977-.637.712-1.519 1.41-2.614 1.708-.394.108-.62.396-.62.65v4.002c0 .26.22.515.553.55 1.293.137 1.936.53 2.491.868l.04.025c.27.164.495.296.776.393.277.095.63.163 1.14.163h3.5v1H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
               </svg>
               @auth
                  <div class="d-inline-block">
                     @if ($article->hasLiked->count() > 0)
                        <form action="/likes/{{$article->id}}" method="post">
                           @csrf
                           @method('DELETE')
                           <button class="btn btn-danger btn-sm" type="submit" title="delete">Unlike</button>
                        </form>
                     @else
                        <form action="/likes/{{$article->id}}" method="post">
                           @csrf
                           <button type="submit" class="btn btn-primary btn-sm">Like</button>
                        </form>          
                     @endif
                  </div>
               @endauth
            </div>
         </div>         
         <div class="col-6 text-right">
            @can('update', $article)
               <a class="btn btn-primary btn-sm" href="/articles/{{$article->id}}/edit">Edit</a>
               <div class="d-inline-block">
                  <form action="/articles/{{$article->id}}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger btn-sm" type="submit" title="delete">Delete</button>
                  </form>
               </div>
            @endcan
         </div>         
      </div>
   </div>


  
   @foreach ($article->comments as $comment)
      <div class="container rounded border border-dark mt-2 pt-1 pb-1" style="background-color: rgb(180, 255, 199)">
         <p class="font-italic font-weight-bold">
            @if ($comment->author->image)
               <img class="profile-image" src="{{ asset($comment->author->image) }}">
            @endif
            {{-- {{$comment->author->name}}, {{ date_format($comment->created_at,"d/m/Y G:i")}}</p> --}}
            {{$comment->author->name}}, {{$comment->created_at}}</p>
            <p>{{$comment->body}}</p>

         @can('update', $comment)
            <a class="btn btn-primary btn-sm" href="/comments/{{$comment->id}}/edit">Edit</a>

            <div class="d-inline-block">
               <form action="/comments/{{$comment->id}}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger btn-sm" type="submit" title="delete">Delete</button>
               </form>
            </div>
         @endcan
      </div>
   @endforeach

   @auth
      <form action="/comments/{{$article->id}}" method="post">
         @csrf
         
         <div class="form-group mt-2">
            <label for="body">Add comment:</label>
            <textarea
               name="body"
               id="body"
               class="form-control"
               rows="3">{{old('body')}}</textarea>
               @error('body')
                  <p class="alert alert-danger">{{$errors->first('body')}}</p>
               @enderror
         </div>

         <button type="submit" class="btn btn-primary">Submit</button>
      </form>
   @else
      <p class="mt-2">Want to comment? <a href="/register">Register first!</a></p>
   @endauth
</div>

@endsection