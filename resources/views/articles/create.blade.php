@extends('layout')

@section('content')
<div class='container'>
   <h1>New Article</h1>
   <form action="/articles" method="post">
      @csrf
   
      <div class="form-group">
         <label for="title">Title</label>
         <input
            type="text"
            name="title"
            id="title"
            class="form-control"
            value="{{old('title')}}">
            @error('title')
               <p class="alert alert-danger">{{$errors->first('title')}}</p>
            @enderror
      </div>
   
      <div class="form-group">
         <label for="excerpt">Excerpt</label>
         <textarea
            name="excerpt"
            id="excerpt"
            class="form-control">{{old('excerpt')}}</textarea>
            @error('excerpt')
               <p class="alert alert-danger">{{$errors->first('excerpt')}}</p>
            @enderror
      </div>
      
      <div class="form-group">
         <label for="body">Body</label>
         <textarea
            name="body"
            id="body"
            class="form-control"
            rows="10">{{old('body')}}</textarea>
            @error('body')
               <p class="alert alert-danger">{{$errors->first('body')}}</p>
            @enderror
      </div>
      
      <div class="form-group">
         <label for="tags">Tags</label>
         <select
            name="tags[]"
            id="tags"
            class="form-control"
            multiple
         >
            @foreach ($tags as $tag)
               <option value="{{$tag->id}}">{{$tag->name}}</option>
            @endforeach
         </select>
         @error('tags')
            <p class="alert alert-danger">{{$errors->first('tags')}}</p>
         @enderror
      </div>
      
      <button type="submit" class="btn btn-primary">Submit</button>
   </form>
</div>
@endsection