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


    <nav>
        <h1><a href="{{route('posts.index')}}">Blog</a></h1>
        <div class="nav-links">
            <a href="{{route('posts.create')}}">Create post</a>
            <a href="{{route('posts.index')}}">Posts</a>
            <a href="{{route('tags.index')}}">Tags</a>
        </div>
    </nav>
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
    @if(session('success'))
        <div style="color: green">{{session('success')}}</div>
    @endif
    @yield('content')
</div>
<script>
    const toggle = document.getElementById('theme_toggle');
    toggle.onclick = () => {
        document.documentElement.dataset.theme = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
        localStorage.setItem('theme', document.documentElement.dataset.theme);
    };
    if (localStorage.getItem('theme') === 'dark') document.documentElement.dataset.theme = 'dark';
</script>
</body>
</html>
