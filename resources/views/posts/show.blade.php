@extends('layouts.app')

@section('content')
    <div class="post-show-container">
        <div class="post-show-image-container">
            <img src="{{$post->thumbnail_url}}" alt="Post preview">
        </div>
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->content }}</p>
        <p>Теги: @foreach($post->tags as $tag)
                <span class="tag">{{ $tag->name }}</span>
            @endforeach</p>
        <a href="{{ route('posts.index') }}">Back</a>
    </div>
@endsection
