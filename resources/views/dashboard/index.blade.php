@extends('layouts.app')

@section('content')
   @can('dashboard', Auth::user())
      <h1>Dashboard</h1>
      <p>Users: {{$users->count()}}</p>
      <p>Articles: {{$articles->count()}}</p>
      <p>Comments: {{$comments->count()}}</p>
   @endcan

@endsection
