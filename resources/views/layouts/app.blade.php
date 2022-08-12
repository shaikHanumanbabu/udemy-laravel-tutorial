<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel App - @yield('title')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ mix('js/custom.js') }}" defer></script>
</head>
{{-- composer require laravel/ui --}}
{{-- php artisan ui bootstrap --}}
{{-- php artisan ui:controllers --}}
{{-- $comment->blogPost()->associate($bp)->save(); --}}
{{-- $bp->comments()->save($comment); --}}
{{-- $bp->comments()->saveMany([$comment, $comment2]); --}}
{{-- BlogPost::has('comments')->get(); --}}
{{-- BlogPost::has('comments', '>=', 2)->get(); --}}
{{-- BlogPost::whereHas('comments', function($query){ $query->where('content', 'like', '%sample%'); })->get(); --}}
{{-- BlogPost::doesNotHave('comments')->get();; --}}
{{-- BlogPost::doesNotHave('comments')->get();; --}}
{{-- ./vendor/bin/phpunit  --}}
{{-- ./vendor/bin/phpunit --filter testsee1BlogPostWhenThereIs1  tests/Feature/PostTest.php; --}}
{{-- Comment::factory()->count(10)->create(['blog_post_id'=> 3]); --}}
<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottom shadow-sm mb-3">
        <h5 class="my-0 mr-md-auto font-weight-normal">Laravel App</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="{{ route('home.index') }}">Home</a>
            <a class="p-2 text-dark" href="{{ route('home.contact') }}">Contact</a>
            <a class="p-2 text-dark" href="{{ route('posts.index') }}">Blog Posts</a>
            <a class="p-2 text-dark" href="{{ route('posts.create') }}">Add Post</a>
            @guest
                @if (Route::has('register'))
                    <a class="p-2 text-dark" href="{{ route('register') }}">Register</a>
                @endif
                <a class="p-2 text-dark" href="{{ route('login') }}">Login</a>
            @else
                <a onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="p-2 text-dark" href="{{ route('logout') }}">Logout ({{ Auth::user()->name }})</a>
                <form style="display: none" id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            @endguest
        </nav>
    </div>
   <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
   </div> 
</body>
</html>