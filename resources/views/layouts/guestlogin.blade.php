<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleheader.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <title>ClothingandMore</title>
</head>

<body>
    <nav class="navbar navbar-expand-sm  nav-bar">
        <a class="navbar-brand" href="{{ route('main') }}"><img src="{{ asset('images/logo.png') }}"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav w-100 d-flex justify-content-between pl-5 pr-5">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop.products', 'hombres') }}">Hombre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop.products', 'mujeres') }}">Mujeres</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop.cart') }}">
                        Carrito
                        <span>
                            @if (Cart::count() > 0)
                                <span class="cart-count">
                                    @if (Cart::count() < 10)
                                        <span> {{ Cart::count() }} </span>
                                    @else
                                        <span>9+</span>
                                    @endif
                                </span>
                            @endif
                        </span>
                    </a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            {{ Auth::user()->firstname }}
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                Log out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
    <footer>
        <div class="container redes">
            <div class="row alig-vertical">
                <div class="col-md-4 py-4 text-white">
                    <p>Dirección: xxx-xxxx-xxx</p>
                    <p>Politicas de Derecho</p>
                    <p>Politica de Privacidad</p>
                </div>

                <div class="col-md-4 py-4 text-white">
                    <img src="{{ asset('images/whatsapp.svg') }}" alt="">
                    <p>Operador : Entel</p>
                    <p>+51 999 999 999</p>
                </div>

                <div class="col-md-4 py-4">
                    <div class="redes">
                        <ul class="d-flex">
                            <li class="li-img">
                                <a href="">
                                    <img src="{{ asset('images/youtube.svg') }}" alt="" class="img-fluid">
                                    <span class="red-img">Youtube</span>
                                </a>
                            </li>
                            <li class="li-img">
                                <a href="">
                                    <img src="{{ asset('images/instagram-sketched.svg') }}" alt="" class="img-fluid">
                                    <span class="red-img">Instagram</span>
                                </a>
                            </li>
                            <li class="li-img">
                                <a href="">
                                    <img src="{{ asset('images/facebook.svg') }}" alt="" class="img-fluid">
                                    <span class="red-img">Facebook</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="descripCopyright bg-dark col-md-12">
                    <p class="pie-footer text-center text-white">Letsy Villanueva, Frank Nuñez Derechos Reservados
                    </p>
                </div>
            </div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/javascript.util/0.12.12/javascript.util.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</body>
</html>
