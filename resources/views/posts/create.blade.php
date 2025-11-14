@extends('layouts.app')

@section('content')
    <h2>Додати пост</h2>
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">  <!-- multipart для файлів! -->
        @csrf
        <div>
            <label for="title">Заголовок:</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required>
            @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="content">Вміст:</label>
            <textarea name="content" id="content" required>{{ old('content') }}</textarea>
            @error('content') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="thumbnail">Thumbnail (зображення прев'ю):</label>
            <input type="file" name="thumbnail" id="thumbnail" accept="image/*">
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

        <button type="submit">Створити</button>
    </form>
@endsection
