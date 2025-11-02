@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Category Edit</h1>
        </div>

        <div class="">
            <div class="row justify-content-center">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body shadow">
                            <div class="p-3">
                                <a href="{{ route('category#list') }}" class="btn btn-primary">Back</a>
                            </div>
                            <form action="{{ route('category#update',$editCategory->id) }}" method="post" class="p-3 rounded">
                                @csrf

                                <input type="hidden" name='id' value="{{ $editCategory->id }}">
                                <div>
                                    <input type="text" name="categoryName" value="{{ old('categoryName',$editCategory->name) }}"
                                        class=" form-control @error('categoryName')
                                        is-invalid
                                    @enderror "
                                        placeholder="Category Name...">
                                    @error('categoryName')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                                <input type="submit" value="Update" class="btn btn-outline-primary mt-3">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection