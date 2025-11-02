@extends('user.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid py-5">

        <!-- Page Heading -->
        <div class="py-5 my-5">
            <div class="row">
                <div class="col-8 offset-2">

                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route('user#changePassword') }}" method="post" class="p-3 rounded">

                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Old Password</label>
                                    <input type="password" name="oldPassword"
                                        class="form-control @error('oldPassword')
                                        is-invalid
                                    @enderror"
                                        placeholder="Enter Old Password..." >
                                    @error('oldPassword')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror

                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="newPassword"
                                        class="form-control @error('newPassword')
                                        is-invalid
                                    @enderror "
                                        placeholder="Enter New Password..." >
                                    @error('newPassword')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror

                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="confirmPassword"
                                        class="form-control @error('confirmPassword')
                                        is-invalid
                                    @enderror "
                                        placeholder="Enter Confirm Password...">
                                    @error('confirmPassword')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror

                                </div>
                                <div class="d-flex gap-2">
                                    <input type="submit" value="Save" class="btn text-white" style="background-color: #81C408;">
                                    <a class="btn btn-light text-dark border border-1" href="{{ route('user#home') }}">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection