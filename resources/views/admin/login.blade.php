
@extends('layouts.adminlogin')
@section('content')
<div class="login-container">
    <p>Login</p>
    <form action=" {{ route('login.admin') }} " method="POST">
        {{ csrf_field() }}
        <div class="form-group form-group-default" id="emailGroup">
            <label>E-mail</label>
            <div class="controls">
                <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="E-mail" class="form-control" required>
            </div>
        </div>
        <div class="form-group form-group-default" id="passwordGroup">
            <label>Password</label>
            <div class="controls">
                <input type="password" name="password" placeholder="Password" class="form-control" required>
            </div>
        </div>
        <div class="form-group" id="rememberMeGroup">
            <div class="controls">
                <input type="checkbox" name="remember" id="remember" value="1"><label for="remember" class="remember-me-text">Recuerdame</label>
            </div>
        </div>
        <button type="submit" class="btn btn-block login-button">
            <span class="signingin hidden"><span class="voyager-refresh"></span> ...</span>
            <span class="signin">Login</span>
        </button>
    </form>
    <div style="clear:both"></div>
    @if(!$errors->isEmpty())
        <div class="alert alert-red">
            <ul class="list-unstyled">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div> <!-- .login-container -->
@endsection
