@extends('layouts.app')

@section('content')
   @can('admin', Auth::user())
      <h1>Dashboard</h1>
      <a class="btn btn-primary" href="/dashboard/users">Users</a>
   @endcan

@endsection
