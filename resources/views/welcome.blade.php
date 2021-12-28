<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Republik Kode</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{asset('landing_page/assets/img/favicon.ico')}}" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic"
        rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Merienda+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Third party plugin CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css"
        rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{asset('landing_page/css/styles.css')}}" rel="stylesheet" />

    <script>
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 80) {
            document.getElementById("mainNav").style.padding = "3rem 1rem";
            document.getElementById("mainNav").style.backgroundColor = "rgba(0,0,0,0.3)";
            document.getElementById("brand").style.fontSize = "1.25rem";
        } else {
            document.getElementById("mainNav").style.padding = "8rem 1rem";
            document.getElementById("mainNav").style.backgroundColor = "rgba(0,0,0,0)";
            document.getElementById("brand").style.fontSize = "1.75rem";
            
        }
        } 
    </script>
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container">
            <a id="brand" class="navbar-brand js-scroll-trigger" href="{{url('/')}}">Republik Kode</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto my-2 my-lg-0">
                    @if (Route::has('login'))
                    @auth
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ url('/home') }}">Home</a></li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{url('/profil')}}">Profil</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @else
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ route('login') }}">Login</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item"><a class="nav-link js-scroll-trigger"
                            href="{{ route('register') }}">Register</a></li>
                    @endif
                    @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-10 align-self-end">
                    <h1 class="text-uppercase text-white font-weight-bold">Forum bersama untuk developer</h1>
                    <hr class="divider my-4" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 font-weight-light mb-5">Mulailah Mengoding dari Hari Ini</p>
                    <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">Lebih lagi</a>
                </div>
            </div>
        </div>
    </header>
    <!-- About-->
    <section class="page-section bg-primary" id="about">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mt-0">Kami ingin membantu memenuhi kebutuhan Anda!</h2>
                    <hr class="divider light my-4" />
                    <p class="text-white-50 mb-4">Daftarkan diri Anda dan bergabung dengan forum untuk berdiskusi
                        seputar dunia pemrograman bersama dengan lebih dari 100000 programmer lainnya.</p>
                    <a class="btn btn-light btn-xl js-scroll-trigger" href="{{ route('register') }}">Daftar</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Services-->
    <section class="page-section" id="services">
        <div class="container">
            <h2 class="text-center mt-0">Fasilitas Kami</h2>
            <hr class="divider my-4" />
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <i class="fas fa-4x fa-gem text-primary mb-4"></i>
                        <h3 class="h4 mb-2">Respon Cepat</h3>
                        <p class="text-muted mb-0">Pengguna aktif yang tanggap terhadap pertanyaan baru</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <i class="fas fa-4x fa-laptop-code text-primary mb-4"></i>
                        <h3 class="h4 mb-2">Kekinian</h3>
                        <p class="text-muted mb-0">Topik yang dibahas sangat baru dan dibahas dengan ringan</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <i class="fas fa-4x fa-globe text-primary mb-4"></i>
                        <h3 class="h4 mb-2">Peluang Komunitas</h3>
                        <p class="text-muted mb-0">Memberikan anda komunitas besar dalam dunia programming</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <i class="fas fa-4x fa-heart text-primary mb-4"></i>
                        <h3 class="h4 mb-2">Saling Menghargai</h3>
                        <p class="text-muted mb-0">Setiap anggota yang ada menghargai setiap pertanyaan dan tanggapan
                            satu sama lain</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="bg-danger py-5">
        <div class="container">
            <div class="text-sans small text-center text-white">Copyright ©2021 - Kelompok 4</div>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <!-- Third party plugin JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>