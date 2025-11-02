@extends('admin.layouts.master')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pizza Sizes Edit</h1>
    </div>

    <div class="">
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="card">
                    <div class="card-body shadow">
                        <div class="p-3">
                            <a href="{{ route('size#listPage') }}" class="btn btn-primary">Back</a>
                        </div>
                        <form action="{{ route('size#update') }}" method="post" class="p-3 rounded">

                            @csrf

                            <input type="hidden" name='id' value="{{ $editSize->id }}">

                            <div class="mb-3">
                                <input type="text" name="pizzaSize" value="{{ old('pizzaSize',$editSize->size) }}"
                                    class=" form-control @error('pizzaSize')
                                    is-invalid
                                @enderror "
                                    placeholder="Enter Pizza Size...">
                                @error('pizzaSize')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div>
                                <input type="text" name="price" value="{{ old('price',$editSize->price) }}"
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