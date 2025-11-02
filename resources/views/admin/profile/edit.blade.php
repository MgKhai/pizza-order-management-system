@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Admin Profile ( <span
                                class="text-danger text-capitalize">{{ Auth::user()->role }}</span> )
                        </h6>
                    </div>
                </div>
            </div>
            <form action="{{ route('profile#updateProfile') }}" method="post" enctype="multipart/form-data">

                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">

                            <img class="img-profile img-thumbnail w-100" style="height: 200px; object-fit: cover;"
                                id="output"
                                src="{{ asset(Auth::user()->profile == null ? '/default/defaultProfile.jpg' : '/profile/' . Auth::user()->profile) }}">


                            <input type="file" accept="image/*" name="image" id=""
                                class="form-control mt-1 @error('image')
                                is-invalid
                            @enderror "
                                onchange="loadFile(event)">
                            @error('image')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                        </div>
                        <div class="col">

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Name</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name')
                                            is-invalid
                                        @enderror "
                                            placeholder="Enter Name..."
                                            value="{{ old('name', Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname) }}">
                                        @error('name')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Email</label>
                                        <input type="text" name="email"
                                            class="form-control @error('email')
                                            is-invalid
                                        @enderror "
                                            value="{{ old('email', Auth::user()->email) }}" placeholder="Enter Email...">
                                        @error('email')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Phone</label>
                                        <input type="text" name="phone"
                                            class="form-control @error('phone')
                                            is-invalid
                                        @enderror "
                                            value="{{ old('phone', Auth::user()->phone) }}" placeholder="09xxxxxx">
                                        @error('phone')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Address</label>
                                        <input type="text" name="address"
                                            class="form-control @error('address')
                                            is-invalid
                                        @enderror "
                                            value="{{ old('address', Auth::user()->address) }}"
                                            placeholder="Enter Address...">
                                        @error('Address')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                            <div>
                                <a href="{{ route('profile#changePassword') }}" class="text-primary">Change password</a>
                            </div>

                            <input type="submit" value="Update" class="btn btn-primary mt-3">
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
