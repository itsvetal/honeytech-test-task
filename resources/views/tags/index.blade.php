@extends('layouts.app')

@section('content')
    <div class="tag-index-container">
        <h2>Tag list</h2>
        <div class="tag-list">
            @foreach($tags as $tag)
                <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
                   onmouseover="this.style.transform='scale(1.1)'; this.style.background='rgba(52,144,220,0.2)';"
                   onmouseout="this.style.transform='scale(1)'; this.style.background='transparent';">
                    {{ $tag->name }} ({{ $tag->posts_count }})
                </a>
            @endforeach
            <button class="action-button"><a href="{{route('tags.create')}}">Add tag</a></button>
        </div>
    </div>
@endsection
