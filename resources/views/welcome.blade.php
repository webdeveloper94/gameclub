<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bosh sahifa</title>

        <!-- Fonts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- head section of your HTML file -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    </head>
    <body>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="img/ps52.jpeg" alt="Slide 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Biz bilan o'yin klubingiz ishini avtomatlashtiring va foydangizni oshiring.</h5>
                        <p><button class="btn btn-light">
                            @if (Route::has('login'))
                                @auth
                               <a  href="{{ url('/dashboard') }}">Sahifaga kirish</a>
                           @else
                               <a href="{{ route('login') }}">Sahifaga kirish</a>
                                 @endauth
                           @endif
                         </button></p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/ps52.jpeg" alt="Slide 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>O'yin klubingiz, maxsulotlar va ishchilarni doimiy nazorat qiling.</h5>
                        <p><button class="btn btn-light">
                            @if (Route::has('login'))
                                @auth
                               <a  href="{{ url('/dashboard') }}">Sahifaga kirish</a>
                           @else
                               <a href="{{ route('login') }}">Sahifaga kirish</a>
                                 @endauth
                           @endif
                         </button></p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/ps52.jpeg" alt="Slide 3">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Qog'oz va ruchkadan voz kechish vaqti keldi, vaqtingizni tejang.</h5>
                        <p><button class="btn btn-light">
                            @if (Route::has('login'))
                                @auth
                               <a  href="{{ url('/dashboard') }}">Sahifaga kirish</a>
                           @else
                               <a href="{{ route('login') }}">Sahifaga kirish</a>
                                 @endauth
                           @endif
                         </button></p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Oldingi</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Keyingi</span>
            </a>
        </div>
                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        Barcha huquqlar himoyalangan.
                    </footer>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
