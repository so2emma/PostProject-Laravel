<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <title>Laravel Blogging App - @yield('title')</title>
</head>

<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottom shadow-sm mb-3">
        <h5 class="my-0 mr-md-auto cont-weight-normal">Laravel Blogging App</h5>

        <nav class="my-2 my-md-0 mr-md-3">
            <a href="{{ route('home.index') }}" class="p-2 text-dark">{{ __("Home") }}</a>
            <a href="{{ route('home.contact') }}" class="p-2 text-dark">{{ __("Contact") }}</a>
            <a href="{{ route('posts.index') }}" class="p-2 text-dark">{{ __("Blog Post") }}</a>
            <a href="{{ route('posts.create') }}" class="p-2 text-dark">{{ __("Add") }}</a>

            @guest()
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="p-2 text-dark">{{ __("Register") }}</a>
                @endif
                <a href="{{ route('login') }}" class="p-2 text-dark">{{ __("Login") }}</a>

                @else
                <a class="p-2 text-dark" href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                    >{{ __("Logout") }} ({{ Auth::user()->name }})</a>

                <form id="logout-form" action={{ route('logout') }} method="POST"
                    style="display: none;">
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
