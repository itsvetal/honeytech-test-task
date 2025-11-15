<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog</title>
    @vite(['resources/scss/app.scss'])
</head>
<body>
<div class="container">
    <button id="theme_toggle">🌙 Theme Switcher</button>
    <nav>
        <a href="{{route('posts.index')}}">Posts</a>
        <a href="{{route('tags.index')}}">Tags</a>
        <a href="{{route('posts.create')}}">Add post</a>
        <a href="{{route('tags.create')}}">Add tag</a>
    </nav>
    @if(session('success'))
        <div style="color: green">{{session('success')}}</div>
    @endif
    @yield('content')
</div>
<script>
    const toggle = document.getElementById('theme_toggle');
    // toggle.textContent = '🌙 Theme Switcher';
    toggle.onclick = () => {
        document.documentElement.dataset.theme = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
        localStorage.setItem('theme', document.documentElement.dataset.theme);
    };
    if (localStorage.getItem('theme') === 'dark') document.documentElement.dataset.theme = 'dark';
</script>
</body>
</html>
