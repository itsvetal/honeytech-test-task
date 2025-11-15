@extends('layouts.app')

@section('content')
    <img src="{{$post->thumbnail_url}}" alt="Post preview">
    <h2>{{ $post->title }}</h2>
    <p>{{ $post->content }}</p>
    <p>Теги: @foreach($post->tags as $tag) <span class="tag">{{ $tag->name }}</span> @endforeach</p>
    <a href="{{ route('posts.index') }}">Back</a>
@endsection
