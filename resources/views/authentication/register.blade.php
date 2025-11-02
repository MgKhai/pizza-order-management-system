@extends('authentication.layouts.master')

@section('content')
    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5" style="background-color: rgba(255, 255, 255, 0.8)">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row justify-content-center">

                    <div class="col-lg-8">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text"
                                            class="form-control form-control-user @error('name') is-invalid @enderror "
                                            id="exampleFirstName" placeholder="Enter Name..." name="name" value="{{old('name')}}">

                                        @error('name')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text"
                                            class="form-control form-control-user @error('phone') is-invalid @enderror "
                                            id="exampleLastName" placeholder="Phone Number..." name="phone"
                                            value="{{old('phone')}}">

                                        @error('phone')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror

                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email"
                                        class="form-control form-control-user @error('email') is-invalid @enderror "
                                        id="exampleInputEmail" placeholder="Email Address" name="email" value="{{old('email')}}">

                                    @error('email')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password"
                                            class="form-control form-control-user @error('password') is-invalid @enderror "
                                            id="exampleInputPassword" placeholder="Password" name="password">

                                        @error('password')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror

                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password"
                                            class="form-control form-control-user @error('password_confirmation') is-invalid @enderror "
                                            id="exampleRepeatPassword" placeholder="Repeat Password"
                                            name="password_confirmation">

                                        @error('password_confirmation')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror

                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                            <hr>

                            <div class="text-center">
                                <a class="small text-success" href="{{ route('login') }}">Already have an account?
                                    Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
