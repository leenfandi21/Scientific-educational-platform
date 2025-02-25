<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="container">
        <nav>
            <ul>
                @guest
                    @if (Route::has('login'))
                        <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    @endif

                    @if (Route::has('register'))
                        <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    @endif
                @else
                    <li>{{ Auth::user()->name }}</li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    </li>
                @endguest
            </ul>
        </nav>

        @yield('content')
    </div>
</body>
</html>
