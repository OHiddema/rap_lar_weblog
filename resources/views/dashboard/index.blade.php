@extends('layouts.app')

@section('content')
   @can('dashboard', Auth::user())
      <h1>Dashboard</h1>
      <div class="container rounded border border-dark" style="background-color: rgb(180, 255, 199)">
         <p>Total number of users: {{$users->count()}}</p>
         Roles:
         <div class="container rounded border border-dark mb-1" style="background-color: rgb(180, 234, 255)">
            @foreach ($roles as $key => $value)
               <div>{{$key}}: {{$value}} </div>
            @endforeach            
         </div>
      </div>

      <div class="container rounded border border-dark mt-2" style="background-color: rgb(180, 255, 199)">
         <p>Total number of articles: {{$articles->count()}}</p>
         Written by:
         <div class="container rounded border border-dark mb-1" style="background-color: rgb(180, 234, 255)">
            @foreach ($articles_per_user as $key => $value)
               <div>{{$key}}: {{$value}} </div>
            @endforeach            
         </div>
      </div>

      <div class="container rounded border border-dark mt-2" style="background-color: rgb(180, 255, 199)">
         <p>Total number of comments: {{$comments->count()}}</p>
         Written by:
         <div class="container rounded border border-dark mb-1" style="background-color: rgb(180, 234, 255)">
            @foreach ($comments_per_user as $key => $value)
               <div>{{$key}}: {{$value}} </div>
            @endforeach            
         </div>
      </div>
      @endcan

@endsection
