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
    <title>Test</title>
</head>

<body>
    <nav>
        <div class="nav-bar">
            <a href="{{ route('shop') }}"><img src="{{ asset('images/logo.png') }}"></a>
            <ul class="nav-options">
                <li>
                    <a href="{{ route('shop.products') }}">Mujer </a>
                </li>
                <li>
                    <a href="{{ route('shop.products') }}">Hombre</a>

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
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->firstname }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"
                            style="background-color: #4B4A4C">
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
