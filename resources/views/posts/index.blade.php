@extends('layouts.app');

@section('content')
    <h2>Post list</h2>
    <form action="{{route('posts.index')}}"></form>
    
@endsection
