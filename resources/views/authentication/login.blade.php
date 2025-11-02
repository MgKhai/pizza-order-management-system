@extends('authentication.layouts.master')

@section('content')

    <div class="container h-100 d-flex justify-content-center align-items-center mt-5">
        <div class="col-11 col-lg-6 card p-5 o-hidden rounded-2 shadow-lg" style="background-color: rgba(255, 255, 255, 0.8)">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
            </div>
            <form class="user" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input type="email"
                        class="form-control form-control-user @error('email')
                is-invalid
            @enderror"
                        id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..."
                        name="email" value="{{ old('email') }}">

                    @error('email')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror

                </div>
                <div class="form-group">
                    <input type="password"
                        class="form-control form-control-user @error('password')
                is-invalid
            @enderror"
                        id="exampleInputPassword" placeholder="Password" name="password" value="{{ old('password') }}">

                    @error('password')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror

                </div>

                <button type="submit" class="btn btn-success btn-user btn-block">
                    Login
                </button>
                <hr>
                <a href="{{ route('sociallogin#redirect', 'google') }}"
                    class="btn btn-google btn-user btn-block d-flex align-items-center justify-content-center">
                    <i class="fab fa-google fa-fw pt-1 mx-1"></i> Login with Google
                </a>
                <a href="{{ route('sociallogin#redirect', 'github') }}"
                    class="btn btn-facebook btn-user bg-dark btn-block d-flex align-items-center justify-content-center">
                    <i class="fa-brands fa-github fa-fw mx-1"></i> Login with Github
                </a>
            </form>
            <hr>
            <div class="text-center">
                <a class="small text-success" href="{{ route('register') }}">Create an Account!</a>
            </div>
        </div>
    </div>
@endsection
