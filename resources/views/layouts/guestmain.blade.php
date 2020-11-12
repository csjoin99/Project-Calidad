<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">   
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <title>ClothingandMore</title>
</head>
    <body>
        <nav class="nav-main">
            <div class="nav-bar">
                <a href="{{ route('main') }}"><img src="{{ asset('images/logo.png') }}"></a>
                <ul class="nav-options">
                    <li>
                        <a href="{{ route('shop.products','hombres') }}">Hombre</a>
                    </li>
                    <li>
                        <a href="{{ route('shop.products','mujeres') }}">Mujer</a>
                    </li>
                    <li>
                        <a href="{{ route('shop.cart') }}">Carrito</a>
                        @if (Cart::count() > 0)
                            <span class="cart-count">
                                @if (Cart::count() < 10)
                                    <span> {{ Cart::count() }} </span>
                                @else
                                    <span>9+</span>
                                @endif
                            </span>
                        @endif
                    </li>
                    <li>
                        <a href="#">Contactenos</a>
                    </li>
                </ul>
                <ul class="nav-login">
                    @guest
                        <li>
                            <a href="{{ route('login') }}">Iniciar sesión</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @else
                        <li style="width: 180px" class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->firstname }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="background-color: #4B4A4C">
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
            <h1 class="nav-title">{{ $Titulo }}</h1>
        </nav>
        <body>
            @yield('content')    
        </body>
        <footer>
            <div class="container redes">
                <div class="row alig-vertical">
                    <div class="col-md-4 py-4 text-white">
                        <p>Dirección: xxx-xxxx-xxx</p>
                        <p>Politicas de Derecho</p>
                        <p>Politica de Privacidad</p>
                    </div>
                    <div class="col-md-4 py-4 text-white">
                        <img src="{{asset('images/whatsapp.svg')}}" alt="">
                        <p>Operador : Entel</p>
                        <p>+51 999 999 999</p>
                    </div>
                    <div class="col-md-4 py-4">
                        <div class="redes">
                            <ul class="d-flex">
                                <li class="li-img">
                                    <a href="">
                                        <img src="{{asset('images/youtube.svg')}}" alt="" class="img-fluid">
                                        <span class="red-img">Youtube</span>
                                        </a>
                                    </li>
                                <li class="li-img">
                                    <a href="">
                                        <img src="{{asset('images/instagram-sketched.svg')}}" alt="" class="img-fluid"> 
                                        <span class="red-img">Instagram</span>
                                    </a>
                                </li>
                                <li class="li-img">
                                    <a href="">
                                        <img src="{{asset('images/facebook.svg')}}" alt="" class="img-fluid"> 
                                        <span class="red-img">Facebook</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="descripCopyright bg-dark col-md-12">
                        <p class="pie-footer text-center text-white">Letsy Villanueva, Frank Nuñez Derechos Reservados</p>
                    </div>
                </div>
        </footer>
        
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/javascript.util/0.12.12/javascript.util.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</html>