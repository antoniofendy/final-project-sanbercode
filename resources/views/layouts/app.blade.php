<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Republik Kode') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.tiny.cloud/1/16sx1ysz0h8tnez6gw0ymqvzgeainqb7x62avti907is5j20/tinymce/5/tinymce.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merienda+One&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>

    </style>

</head>

<body style="background-image: url({{asset('oriental-tiles/oriental-tiles.png')}})">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-warning shadow-sm sticky-top"
            style="box-shadow: 0 8px 30px -6px black">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h3><span class="badge badge-primary">Stack Over Wow</span></h3>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @if (Auth::check())
                    <ul class="navbar-nav mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/home')}}"><b>Home</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/user/pertanyaan/buat')}}"><b>Buat Pertanyaan</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/pertanyaan/'. Auth::id())}}"><b>Pertanyaan Saya</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/jawaban/'. Auth::id())}}"><b>Jawaban Saya</b></a>
                        </li>
                    </ul>
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto mb-2">
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
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
    @include('sweetalert::alert')

</body>

</html>