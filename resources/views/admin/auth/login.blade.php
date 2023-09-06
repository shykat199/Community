@extends('admin.auth.layout.master_auth')
@section('auth.content')

    @if(\Illuminate\Support\Facades\Session::has('success'))
        <div class="alert alert-success m-2" role="alert">
            <i class="dripicons-checkmark me-2"></i>
            <strong>{{\Illuminate\Support\Facades\Session::get('success')}}</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"
                    style="float: right"></button>
        </div>
    @endif

    @if(\Illuminate\Support\Facades\Session::has('error'))
        <div class="alert  alert-danger m-2" role="alert">
            <i class="dripicons-checkmark me-2"></i>
            <strong>{{\Illuminate\Support\Facades\Session::get('error')}}</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"
                    style="float: right"></button>
        </div>
    @endif

{{--        <form action="{{route('admin.login')}}" method="post">--}}

    <section class="community-login-area">
        <a href="#" class="home-icon"><i class="fa fa-home" aria-hidden="true"></i></a>
        <div class="community-login">
            <div class="login-logo">
                <a href="#"><img src="{{asset("community-frontend/assets/images/logo.png")}}" alt="Logo"></a>
            </div>
            <form action="{{route('admin.login')}}" class="community-loginForm" method="post">
                @csrf
                <h5 class="login-title">Login</h5>
                <div class=" login-box">
                    <input type="email" name="email">
                    <label>Username or email</label>
                </div>
                <div class="login-box">
                    <input type="password" class="loginPassword" name="password">
                    <label>Password</label>
                </div>
                <div class="remember-box">
                    <span>
                        <input type="checkbox" id="remember">
                        <label for="remember">Remember me</label>
                    </span>
                    <a href="#" class="forgot-pass">Forgot Password</a>
                </div>
                <div class="login-btn-list">
                    <button type="submit" class="social-theme-btn">Login</button>
                    <p>Or</p>
                    <button type="submit" class="social-theme-btn googl-btn">Log In with Google</button>
                </div>
                <div>
                    <a href="{{route('admin.register_page')}}">Don't Have Account</a>
                </div>
            </form>
        </div>
    </section>

@endsection
