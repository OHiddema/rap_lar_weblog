@extends('layouts.app')

@section('content')
<a class="btn btn-primary" href="/articles">All articles</a><br>

<div class="container rounded border border-dark pb-2 mt-2" style="background-color: rgb(180, 234, 255)">
   <h1>{{$article->title}}</h1>
   <p class="m-0">by: <a href="/articles/?user={{$article->author->id}}">{{$article->author->name}}</a></p> 
   <p class="m-0">
      tags:
      @foreach ($article->tags as $tag)
         <a href="/articles/?tag={{$tag->name}}">{{$tag->name}}</a>
      @endforeach
   </p>
   <p class="mt-2">{{$article->body}}</p>

   @auth
      <div class="d-inline-block">
      @if (\App\Models\Like::where('article_id',$article->id)->where('user_id',auth()->user()->id)->count() > 0)
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
   <div class="d-inline-block">This article has {{$article->likes->count()}} likes</div>

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
  
   @foreach ($article->comments as $comment)
      <div class="container rounded border border-dark mt-2 pt-1 pb-1" style="background-color: rgb(180, 255, 199)">
         <p class="font-italic font-weight-bold">{{$comment->author->name}}, {{ date_format($comment->created_at,"d/m/Y G:i")}}</p>
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