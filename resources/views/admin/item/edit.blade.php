@extends('admin.layouts.master')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add-on Item Edit</h1>
    </div>

    <div class="">
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="card">
                    <div class="card-body shadow">
                        <div class="p-3">
                            <a href="{{ route('item#listPage') }}" class="btn btn-primary">Back</a>
                        </div>
                        <form action="{{ route('item#update') }}" method="post" class="p-3 rounded">

                            @csrf

                            <input type="hidden" name='id' value="{{ $editItem->id }}">

                            <div class="mb-3">
                                <input type="text" name="name" value="{{ old('name',$editItem->name) }}"
                                    class=" form-control @error('name')
                                    is-invalid
                                @enderror "
                                    placeholder="Enter Item Name...">
                                @error('name')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div>
                                <input type="text" name="price" value="{{ old('price',$editItem->price) }}"
                                    class=" form-control @error('price')
                                    is-invalid
                                @enderror "
                                    placeholder="Enter Price...">
                                @error('price')
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