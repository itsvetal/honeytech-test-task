@extends('layouts.app')

@section('content')
    <h2>Tag list</h2>
    <div class="tag-list">
        @foreach($tags as $tag)
            <li><a href="{{ route('posts.index', ['tag' => $tag->name]) }}">{{ $tag->name }}</a>
                <form method="POST" action="{{ route('tags.destroy', $tag) }}" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit">Delete</button>
                </form></li>
        @endforeach
    </div>
@endsection
