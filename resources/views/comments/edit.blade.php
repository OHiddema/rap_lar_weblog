@extends('layouts.app')

@section('content')
   <h1>Edit Comment</h1>

   @if (request('user'))
      <form action="/comments/{{$comment->id}}/?user={{request('user')}}" method="post">
   @else
      <form action="/comments/{{$comment->id}}" method="post">
   @endif

      @csrf
      @method('PUT')
         
      <div class="form-group">
         <label for="body">Comment:</label>
         <textarea
            name="body"
            id="body"
            class="form-control"
            rows="3">{{old('body',$comment->body)}}</textarea>
         @error('body')
            <p class="alert alert-danger">{{$errors->first('body')}}</p>
         @enderror
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
   </form>

@endsection