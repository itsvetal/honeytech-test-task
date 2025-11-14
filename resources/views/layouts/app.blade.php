<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog</title>
    @vite(['$__vite_arguments'])
</head>
<body>
<div class="wrapper">
    <nav>
        <a href="{{route('posts.index')}}">Posts</a>
        <a href="{{route('tags.index')}}">Tags</a>
        <a href="{{route('posts.create')}}">Add post</a>
        <a href="{{route('posts.create')}}">Add tag</a>
    </nav>
    @if(session('success'))
        <div style="color: green">{{session('success')}}</div>
    @endif
    @yield('content')
</div>
</body>
</html>
