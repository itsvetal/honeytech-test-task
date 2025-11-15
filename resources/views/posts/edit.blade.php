@extends('layouts.app')

@section('content')
    <h2>Edit post</h2>

    @if($post->thumbnail)
        <div>
            <label>Current preview image:</label>
            <img src="{{ $post->thumbnail_url }}" id="preview" alt="Current preview image" style="max-width: 200px; height: auto; border-radius: 8px; margin-bottom: 10px;">
            <p>Download a new file to replace.</p>
        </div>
    @else
        <p>Thumbnail missing. Add image.</p>
    @endif

    <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="{{ $post->title }}" required>
            @error('title') <span class="error" style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="content">Content:</label>
            <textarea name="content" id="content" required>{{ $post->content }}</textarea>
            @error('content') <span class="error" style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="thumbnail">Preview image:</label>
            <input type="file" name="thumbnail" id="thumbnail" accept="image/*">
            @error('thumbnail') <span class="error" style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Tags:</label>
            <select name="">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ $post->tags->contains($tag->id) ? 'selected' : '' }}>{{ $tag->name }}</option>
                @endforeach
            </select>
            @error('tags') <span class="error" style="color: red;">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Edit</button>
    </form>

    <script>
        document.getElementById('thumbnail').addEventListener('change', function(event) {
            const preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(event.target.files[0]);
        });
    </script>
@endsection
