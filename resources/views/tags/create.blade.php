@extends('layouts.app')

@section('content')
    <div class="create-tag-container">
        <h2>Add tag</h2>
        <form method="POST" action="{{ route('tags.store') }}">
            @csrf
            <input type="text" name="name" placeholder="Tag title" required>
            <button type="submit">Create</button>
        </form>
    </div>
@endsection
