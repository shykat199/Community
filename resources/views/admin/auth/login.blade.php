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

    <div class="card-body p-4">
        <div class="text-center w-75 m-auto">
            <h4 class="text-dark-50 text-center pb-0 fw-bold">Sign In</h4>
            <p class="text-muted mb-4">Enter your email address and password to access admin panel.</p>
        </div>

        <form action="{{route('admin.login')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="emailaddress" class="form-label">Email address</label>
                <input class="form-control" name="email" type="email" id="emailaddress" required=""
                       placeholder="Enter your email">
                @error('email')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="mb-3">
                <a href="" class="text-muted float-end"><small>Forgot your password?</small></a>
                <label for="password" class="form-label">Password</label>
                <div class="input-group input-group-merge">
                    <input type="password" id="password" name="password" class="form-control"
                           placeholder="Enter your password">
                    <div class="input-group-text" data-password="false">
                        <span class="password-eye"></span>
                    </div>
                </div>
                @error('password')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="mb-3 mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                    <label class="form-check-label" for="checkbox-signin">Remember me</label>
                </div>
            </div>

            <div class="mb-3 mb-0 text-center">
                <button class="btn btn-primary" type="submit"> Log In</button>
            </div>

        </form>
    </div> <!-- end card-body -->
    </div>
    <!-- end card -->

    <div class="row mt-3">
        <div class="col-12 text-center">
            <p class="text-muted">Don't have an account? <a href="{{route('admin.register_page')}}"
                                                            class="text-muted ms-1"><b>Sign Up</b></a></p>
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
