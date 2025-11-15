@extends('layouts.app')

@section('content')
    <h2>Список постів</h2>
    <form method="GET" action="{{ route('posts.index') }}">
        <select name="tag" onchange="this.form.submit()">
            <option value="">All</option>
            @foreach(\App\Modules\Tag\Models\Tag::all() as $tag)
                <option value="{{ $tag->name }}" {{ request('tag') == $tag->name ? 'selected' : '' }}>{{ $tag->name }}</option>
            @endforeach
        </select>
    </form>
    <div class="post-list">
        @foreach($posts as $post)
            <li>
                <img src="{{$post->thumbnail_url}}" alt="">
                <h3><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
                <p>{{ Str::limit($post->content, 100) }}</p>
                <small>Теги: @foreach($post->tags as $tag) <span class="tag">{{ $tag->name }}</span> @endforeach</small>
                <a href="{{ route('posts.edit', $post) }}">Edit</a>
                <form method="POST" action="{{ route('posts.destroy', $post) }}" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </div>
    {{ $posts->links() }}
@endsection
