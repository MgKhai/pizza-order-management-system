@extends('admin.layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="p-3">
                <a href="{{ route('product#list') }}" class="btn btn-primary">Back</a>
            </div>
            <div class="card-body ">
                <div class="row">
                    <!-- Main Image -->
                    <div class="col-md-5">
                        <img src="{{ asset('/imageProduct/'.$detailProduct->product_image) }}"
                            class="main-img w-100 rounded" alt="Main Product" style="height: 380px; object-fit: contain;">
                    </div>

                    <!-- Product Info -->
                    <div class="col-md-6 my-2">
                        <h1 class="text-decoration-underline text-uppercase">{{ $detailProduct->product_name }}</h1>
                        <div class="my-2">
                            <h5 class="">Price</h5>
                            <p>{{ $detailProduct->price }} mmk</p>
                        </div>

                        <div class="my-2">
                            <p><span class="">Stock: </span>{{ $detailProduct->stock }}</p>
                        </div>

                        <div class="my-2">
                            <p><span class="">Category: </span>{{ $detailProduct->category_name }}</p>
                        </div>

                        <div class="my-2">
                            <h5 class="">Ingredients</h5>
                            <p>{{ $detailProduct->ingredients }}</p>
                        </div>

                        <div class="my-2">
                            <h5 class="">Description</h5>
                            <p>{{ $detailProduct->description }}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
