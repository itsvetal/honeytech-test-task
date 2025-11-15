@extends('layouts.app')

@section('content')
    <div class="post-show-container">
        <button class="back-button">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M400-240 160-480l240-240 56 58-142 142h486v80H314l142 142-56 58Z"/>
            </svg>
            <a href="{{ route('posts.index') }}">Back</a>
        </button>
        <div class="post-show-image-container">
            <img src="{{$post->thumbnail_url}}" alt="Post preview">
        </div>
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->content }}</p>
        <div class="post-show-tag">
            <p>Теги: @foreach($post->tags as $tag)
                    <span class="tag">{{ $tag->name }}</span>
                @endforeach</p>
        </div>
    </div>
@endsection
