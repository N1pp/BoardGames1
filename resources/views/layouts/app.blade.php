<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<style>
    body {
        color: white;
    }
</style>
<body style="background: #1d68a7">
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="background: yellowgreen">
        <div class="container" style="background: yellowgreen">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <div class="btn-group">
                            <button type="button" class="btn dropdown-toggle" style="background: #1d68a7"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </button>
                            <div class="dropdown-menu">
                                @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                    <a class="dropdown-item" href="{{ route('admin') }}">Admin</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('home') }}">Cabinet</a>
                                <a class="dropdown-item" href="{{ route('products') }}">Main page</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" style="color: #b91d19"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn dropdown-toggle" style="background: #1d68a7"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Cart
                            </button>
                            <div class="dropdown-menu">
                                @if(session()->get('cart') !== null)
                                    @foreach(session()->get('cart') as $id)
                                        <div class="dropdown-item">
                                            {{\App\Product::find($id)->name}}
                                            <form action="{{route('remove')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$id}}">
                                                <button class="btn btn-sm btn-danger    " type="submit">Remove</button>
                                            </form>
                                        </div>
                                    @endforeach
                                    <form action="{{route('buyProduct')}}" method="post">
                                        @csrf
                                        <button class="btn" type="submit">Buy</button>
                                    </form>
                                @else
                                    Nothing there
                                @endif
                            </div>
                        </div>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
