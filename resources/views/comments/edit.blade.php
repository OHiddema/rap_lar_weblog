@extends('layouts.app')

@section('content')
   <h1>Edit Comment</h1>
   <form action="/comments/{{$comment->id}}" method="post">
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