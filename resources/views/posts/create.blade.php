@extends('layouts.app')

@section('content')
    <h2>Add post</h2>
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required>
            @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="content">Content:</label>
            <textarea name="content" id="content" required>{{ old('content') }}</textarea>
            @error('content') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="thumbnail">Preview image:</label>
            <input type="file" name="thumbnail" id="thumbnail" accept="image/*" onchange="previewImage(event)">
            <img id="preview" style="max-width:200px; display:none; margin-top:10px;">
            <script>
                function previewImage(event) {
                    const preview = document.getElementById('preview');
                    preview.src = URL.createObjectURL(event.target.files[0]);
                    preview.style.display = 'block';
                }
            </script>
            @error('thumbnail') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Теги:</label>
            <select name="tags[]" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            @error('tags') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Create</button>
    </form>
@endsection
