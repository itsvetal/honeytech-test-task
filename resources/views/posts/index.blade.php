@extends('layouts.app')

@section('content')
    <div class="features">
        <button id="theme_toggle">🌙 Theme Switcher</button>
        <button>
            <a href="{{ route('posts.demo') }}"
               class="demo-btn"
               onclick="return confirm('This will remove existing posts and generate new demo data. Continue?');">
                Generate demo posts
            </a>
        </button>
    </div>

    <form method="GET" action="{{ route('posts.index') }}">
        <select class="tag-selector" name="tag" onchange="this.form.submit()">
            <option value="">All</option>
            @foreach(\App\Modules\Tag\Models\Tag::all() as $tag)
                <option
                    value="{{ $tag->name }}" {{ request('tag') == $tag->name ? 'selected' : '' }}>{{ $tag->name }}</option>
            @endforeach
        </select>
    </form>
    <div class="post-list">
        @foreach($posts as $post)
            <li>
                <div class="image-container">
                    <img src="{{$post->thumbnail_url}}" alt="">
                </div>
                <h3><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
                <p>{{ Str::limit($post->content, 100) }}</p>
                <small>Теги: @foreach($post->tags as $tag)
                        <span class="tag">{{ $tag->name }}</span>
                    @endforeach</small>
                <div class="action-button__container">
                    <button class="action-button"><a href="{{ route('posts.edit', $post) }}">Edit</a></button>
                    <form method="POST" action="{{ route('posts.destroy', $post) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </div>
    {{ $posts->links() }}
@endsection
