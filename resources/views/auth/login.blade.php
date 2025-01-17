@extends('layouts.guestlogin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Login</h5>
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form class="form-signin" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-label-group">
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Email address"
                                    required autofocus>
                                <label for="email">E-mail</label>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ 'Correo invalido' }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-label-group">
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                    required>
                                <label for="password">Password</label>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ 'Contraseña invalida' }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">Recordar password</label>
                            </div>
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
