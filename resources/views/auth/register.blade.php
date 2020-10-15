@include('template/header2')

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Registro</h5>
                        <form class="form-signin" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            <div class="form-label-group">
                                <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}"
                                    class="form-control @error('firstname') is-invalid @enderror" required autofocus>
                                <label for="firstname">Nombre</label>
                                @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ 'Nombre invalido' }}</strong>
                                </span>
                                @enderror
                            </div>


                            <div class="form-label-group">
                                <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}"
                                    class="form-control @error('lastname') is-invalid @enderror" required autofocus>
                                <label for="lastname">Apellido</label>
                                @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ 'Apellido invalido' }}</strong>
                                </span>
                                @enderror
                            </div>


                            <div class="form-label-group">
                                <input type="text" id="dni" name="dni" value="{{ old('dni') }}"
                                    class="form-control @error('dni') is-invalid @enderror" required autofocus>
                                <label for="dni">DNI</label>
                                @error('dni')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ 'DNI invalido' }}</strong>
                                </span>
                                @enderror
                            </div>


                            <div class="form-label-group">
                                <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}"
                                    class="form-control @error('telefono') is-invalid @enderror" required autofocus>
                                <label for="telefono">Telefono</label>
                                @error('telefono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ 'Telefono invalido' }}</strong>
                                </span>
                                @enderror
                            </div>


                            <div class="form-label-group">
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Email address" required autofocus>
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
                                    <strong>{{ 'El password debe tener almenos 8 caracteres' }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-label-group">
                                <input type="password" id="password-confirm" name="password_confirmation"
                                    class="form-control" placeholder="Password" required>
                                <label for="password-confirm">Confirmar password</label>
                            </div>
                            <button class="btn btn-lg btn-primary btn-block text-uppercase"
                                type="submit">Registrarse</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
