@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2 card p-3 shadow-sm rounded">
                <form action="{{ route('product#update') }}" method="post" enctype="multipart/form-data">

                    <div class="p-3">
                        <a href="{{ route('product#list') }}" class="btn btn-primary">Back</a>
                    </div>

                    @csrf

                    <input type="hidden" name="oldImage" value="{{ $editProduct->product_image }}">
                    <input type="hidden" name="productId" value="{{ $editProduct->product_id }}">

                    <div class="card-body">
                        <div class="mb-3">
                            <div class="text-center">
                                <img class="img-profile rounded mb-3" id="output" style="width: 200px; height: 200px; object-fit: contain;"
                                    src="{{ asset('/imageProduct/' . $editProduct->product_image) }}">
                            </div>
                            <input type="file" name="image" accept="image/*" id=""
                                class="form-control mt-1 @error('image')
                                is-invalid
                            @enderror "
                                onchange="loadFile(event)">
                            @error('image')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ old('name',$editProduct->product_name) }}"
                                        class="form-control @error('name')
                                            is-invalid
                                        @enderror "
                                        placeholder="Enter Name...">
                                    @error('name')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror

                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <select name="category" id=""
                                        class="form-control @error('category')
                                        is-invalid
                                    @enderror ">
                                        @foreach ($categoryList as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == old('category',$editProduct->category_id)) selected @endif>{{ $item->name }}
                                            </option>
                                        @endforeach
                                        @error('category')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="text" name="price" value="{{ old('price', $editProduct->price) }}"
                                        class="form-control @error('price')
                                            is-invalid
                                        @enderror "
                                        placeholder="Enter Price...">
                                    @error('price')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror

                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="text" name="stock" value="{{ old('stock',$editProduct->stock) }}"
                                        class="form-control @error('stock')
                                            is-invalid
                                        @enderror "
                                        placeholder="Enter Stock...">
                                    @error('stock')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror

                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ingredients</label>
                            <textarea name="ingredients" id="" cols="30" rows="5"
                                class="form-control @error('ingredients')
                                is-invalid
                            @enderror "
                                placeholder="Enter Description...">{{ old('ingredients', $editProduct->ingredients) }}</textarea>
                            @error('ingredients')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="" cols="30" rows="10"
                                class="form-control @error('description')
                                is-invalid
                            @enderror "
                                placeholder="Enter Description...">{{ $editProduct->description }}</textarea>
                            @error('description')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="mb-3">
                            <input type="submit" value="Update Product" class=" btn btn-primary w-100 rounded shadow-sm">
                        </div>
                    </div>
                </form>


            </div>

        </div>
    </div>
@endsection
