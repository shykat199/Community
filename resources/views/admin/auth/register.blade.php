@extends('admin.auth.layout.master_auth')
@section('auth.content')

    @if(\Illuminate\Support\Facades\Session::has('error'))
        <div class="alert alert-danger" role="alert">
            <i class="dripicons-wrong me-2"></i> This is a <strong>{{\Illuminate\Support\Facades\Session::get('error')}}</strong> alert - check it out!
        </div>
    @endif
    @if(\Illuminate\Support\Facades\Session::has('success'))
        <div class="alert alert-danger" role="alert">
            <i class="dripicons-wrong me-2"></i> This is a <strong>{{\Illuminate\Support\Facades\Session::get('success')}}</strong> alert - check it out!
        </div>
    @endif

{{--        <form action="{{route('admin.register')}}" method="post">--}}

    <!-- login page start  -->
    <section class="community-login-area">

        <a href="#" class="home-icon"><i class="fa fa-home" aria-hidden="true"></i></a>
        <div class="community-login">
            <div class="login-logo">
                <a href="#"><img src="{{asset("community-frontend/assets/images/logo.png")}}" alt="Logo"></a>
            </div>
            <form action="{{route('admin.register')}}" class="community-loginForm" method="post">
                @csrf
                <h5 class="login-title">Register</h5>
                <div class=" login-box">
                    <input type="text" name="name">
                    <label>Name</label>
                </div>
                <div class=" login-box">
                    <input type="email" name="email">
                    <label>Email</label>
                </div>
                <div class="login-box">
                    <input type="password" name="password">
                    <label>Password</label>
                </div>
                @error('password')
                <span class="text-danger">{{$message}}</span>
                @enderror

                <article class="regular">
                    <h5>User Role</h5>
                    <input type="radio" name="role" id="rad1" value="{{SERVICE_PROVIDER_ROLE}}">
                    <label for="rad1">Service Provider</label>
                    <input type="radio" name="role" id="rad2" value="{{VENDOR_ROLE}}">
                    <label for="rad2">Vendor</label>
                    <input type="radio" name="role" id="rad3" value="{{USER_ROLE}}">
                    <label for="rad3">User</label>
                </article>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="checkbox-signup">
                        <label class="form-check-label" for="checkbox-signup">I accept <a href="#" class="text-muted">Terms and Conditions</a></label>
                    </div>



                    <div class="login-btn-list">
                        <button type="submit" class="social-theme-btn">Register</button>
                        <p>Or</p>
                        <button type="submit" class="social-theme-btn googl-btn">Log In with Google</button>
                    </div>
                    <div>
                        <a href="{{route('admin.login_page')}}">Have Already Account ?</a>
                    </div>

                </div>


            </form>
            </div>



    </section>





    <!-- login page end  -->

@endsection
