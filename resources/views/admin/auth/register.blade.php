@extends('admin.auth.layout.master_auth')
@section('auth.content')

    @if(\Illuminate\Support\Facades\Session::has('error'))
        <div class="alert alert-danger" role="alert">
            <i class="dripicons-wrong me-2"></i> This is a <strong>{{\Illuminate\Support\Facades\Session::get('error')}}</strong> alert - check it out!
        </div>
    @endif

    <div class="card-body p-4">

        <div class="text-center w-75 m-auto">
            <h4 class="text-dark-50 text-center mt-0 fw-bold">Free Sign Up</h4>
            <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a minute </p>
        </div>

        <form action="{{route('admin.register')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input class="form-control" name="name" type="text" id="fullname" placeholder="Enter your name" >
                @error('name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="emailaddress" class="form-label">Email address</label>
                <input class="form-control" name="email" type="email" id="emailaddress"  placeholder="Enter your email">
                @error('email')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group input-group-merge">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                    <div class="input-group-text" data-password="false">
                        <span class="password-eye"></span>
                    </div>
                </div>
                @error('password')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <article class="regular">
                <h5>User Role</h5>
                <input type="radio" name="user" id="rad1" value="provider">
                <label for="rad1">Service Provider</label>
                <input type="radio" name="user" id="rad2" value="vendor">
                <label for="rad2">Vendor</label>
                <input type="radio" name="user" id="rad3" value="user">
                <label for="rad3">User</label>
            </article>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checkbox-signup">
                    <label class="form-check-label" for="checkbox-signup">I accept <a href="#" class="text-muted">Terms and Conditions</a></label>
                </div>
            </div>

            <div class="mb-3 text-center">
                <button class="btn btn-primary" type="submit"> Sign Up </button>
            </div>

        </form>
    </div> <!-- end card-body -->
    </div>
    <!-- end card -->

    <div class="row mt-3">
        <div class="col-12 text-center">
            <p class="text-muted">Already have account? <a href="{{route('admin.login_page')}}" class="text-muted ms-1"><b>Log In</b></a></p>
        </div> <!-- end col-->
    </div>
@endsection
