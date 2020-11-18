@extends('layouts.app')

@section('content')
   <h1>Email</h1>
   <form action="/contact" method="post">
      @csrf
   
      <div class="form-group">
         <label for="email">Emailadres:</label>
         <input
            type="text"
            name="email"
            id="email"
            class="form-control"
            value="{{old('email')}}">
            @error('email')
               {{-- <p class="alert alert-danger">{{$errors->first('email')}}</p> --}}
               <p class="alert alert-danger">{{$message}}</p>
            @enderror
      </div>
   
      
      <button type="submit" class="btn btn-primary">Submit</button>

      @if (session('message'))
         <p>{{session('message')}}</p> 
      @endif
   </form>
@endsection