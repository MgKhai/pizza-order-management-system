@extends('user.layouts.master')

@section('css_content')
    <style>
        .profile-img {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto;
        }

        .profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        .edit-icon {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: #81C408;
            color: #fff;
            border-radius: 50%;
            padding: 5px;
            font-size: 13px;
            cursor: pointer;
            border: 2px solid #fff;
        }

        .form-control {
            border-radius: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="container p-5">
        <form class="mx-auto" style="max-width: 600px;" action="{{ route('user#profileUpdate') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="text-center mb-4">
                <h3>Edit Profile</h3>
                <div class="profile-img mt-3">
                    <img src="{{ asset(Auth::user()->profile == null ? '/default/defaultProfile.jpg' : '/profile/' . Auth::user()->profile) }}"
                        id="output" alt="Profile">
                    <span class="">

                        <!-- Hidden file input -->
                        <input type="file" name="image" accept="image/*" id="profilePicInput" class="d-none"
                            onchange="loadFile(event)">
                        <!-- Pencil icon as a label -->
                        <label for="profilePicInput"
                            class="position-absolute bottom-0 top-1 end-0 border border-2 border-white shadow rounded-circle "
                            style="cursor: pointer; background-color: #81C408;">
                            <i class="fa-regular fa-pen-to-square text-white bold fs-5 p-2 rounded-circle"></i>
                        </label>
                    </span>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control @error('name')
                    is-invalid
                @enderror" name="name"
                    value="{{ old('name',Auth::user()->name == null ? Auth::user()->nickname : Auth::user()->name) }}"
                    placeholder="Enter Name...">
                @error('name')
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control @error('email')
                    is-invalid
                @enderror" name="email" value="{{ old('email',Auth::user()->email) }}" placeholder="Enter Email...">
                @error('email')
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Contacts Number</label>
                <input type="text" class="form-control @error('phone')
                    is-invalid
                @enderror" name="phone" value="{{ old('phone',Auth::user()->phone) }}"
                    placeholder="Enter Phone Number...">
                    @error('phone')
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" class="form-control @error('address')
                    is-invalid
                @enderror" name="address" value="{{ old('address',Auth::user()->address) }}"
                    placeholder="Enter Address...">
                    @error('address')
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <a href="{{ route('user#changePasswordPage') }}" class="text-primary">Change password</a>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary text-white">Save Changes</button>
                <a class="btn btn-light text-dark border border-1" href="{{ route('user#home') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
