@extends('user.layouts.master')

@section('css_content')
    <style>
        .hero-title {
            color: #62c100;
            font-size: 3rem;
            font-weight: 700;
        }

        .sub-text {
            color: orange;
            font-size: 1.2rem;
            font-weight: 500;
        }

        .search-bar {
            border: 1px solid orange;
            border-radius: 50px;
            overflow: hidden;
        }

        .search-bar input {
            border: none;
            border-radius: 0;
            outline: none;
        }

        .search-bar button {
            background-color: #62c100;
            color: white;
            border: none;
            border-left: 2px solid orange;
            font-weight: 400;
        }

        /*
                    .carousel-caption {
                        background-color: rgba(255, 165, 0, 0.7);
                        height: 50px;
                        padding: 0.5rem 1.0rem;
                        border-radius: 10px;
                        font-size: 1.3rem;
                        font-weight: 600;
                    }

                    .carousel-control-prev-icon,
                    .carousel-control-next-icon {
                        border-radius: 50%;
                        padding: 10px;
                    }

                    .carousel-inner img {
                        border-radius: 20px;
                    } */

        .theme_color {
            background-color: #81C408;
        }
    </style>
@endsection

@section('content')
    @if (request('searchKey'))
        <div class="container p-3">
            <div class="text-center h2 p-4">{{ count($productList) }} results for "{{ request('searchKey') }}"</div>
            <div class="d-flex justify-content-center pb-0">
                <form class="search-bar d-flex bg-white w-50" action="{{ route('user#home') }}" method="get" id="search-form">
                    <input class="w-100 py-3 px-4" name="searchKey" type="text" value="{{ request('searchKey') }}"
                        placeholder="Search">
                    <button type="submit" class="btn btn-primary rounded-pill border-secondary text-white"
                        style="width: 150px;">Submit Now</button>
                </form>
            </div>
        </div>
    @else
        <div class="bg-container"
            style="height: 380px; position: relative; overflow: hidden; background-position: center; background-size: cover;">
            <img src="{{ asset('/backgroundImage/bgImagePizza.jpg') }}" alt="Banner"
                class="w-100 h-100 position-absolute top-0 start-0"
                style="object-fit: cover; z-index: -1; min-height: 380px">
            <div class="container py-5">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="sub-text mb-2">Hot & Fresh</div>
                        <div class="hero-title mb-4">The Pizza<br>To The Heart</div>

                        <form class="search-bar border-end-0 d-flex bg-white w-75" action="{{ route('user#home') }}"
                            method="get">
                            <input class="w-100 py-3 px-4" name="searchKey" type="text"
                                value="{{ request('searchKey') }}" placeholder="Search">
                            <button type="submit" class="btn btn-primary rounded-pill border-secondary text-white"
                                style="width: 150px;">Submit Now</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-5" id="product-section">
        <div class="container-fluid fruite py-1">
            <div class="container py-5">
                <div class="tab-class text-center">
                    <div class="row g-4">
                        @if (!request('searchKey'))
                            <div class="col text-end">
                                <ul class="nav nav-pills d-inline-flex text-center mb-4 mt-1 category-list">
                                    <li class="nav-item">
                                        <a class="d-flex m-2 py-2 bg-light rounded-pill @if (!request('categoryId')) active @endif"
                                            href="{{ route('user#home') }}">
                                            <span class="text-dark" style="width: 130px;">All Items</span>
                                        </a>
                                    </li>

                                    @foreach ($categoryList as $item)
                                        <li class="nav-item">
                                            <a class="d-flex m-2 py-2 bg-light rounded-pill @if ($item->id == request('categoryId')) active @endif "
                                                href="{{ url('user/home?categoryId=' . $item->id) }}">
                                                <span class="text-dark text-capitalize"
                                                    style="width: 130px;">{{ $item->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane fade show p-0 active">
                            <div class="row g-4 pb-5" style="min-height: 300px;">
                                @if (count($productList) != 0)
                                    <div class="col-sm-3">
                                        <div class="card" style="position:sticky; top: 195px;">
                                            <div class="card-body shadow p-3 py-3">
                                                <div class="mb-3">
                                                    <span class="d-flex justify-content-start gap-2 align-items-center"><i
                                                            class="fa-solid fa-sliders"></i>Filters</span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">

                                                        <form action="{{ route('user#home') }}" method="get"
                                                            id="filter-form"
                                                            class="@if (!request('searchKey')) scroll-on-submit @endif">

                                                            <input type="text" name="minPrice"
                                                                value="{{ request('minPrice') }}"
                                                                placeholder="Minimum Price..." class=" form-control my-2 ">
                                                            <input type="text" name="maxPrice"
                                                                value="{{ request('maxPrice') }}"
                                                                placeholder="Maximun Price..." class=" form-control my-2 ">

                                                            <!-- Hidden request('sortingType') -->
                                                            @if (request('sortingType'))
                                                                <input type="hidden" name="sortingType"
                                                                    value="{{ request('sortingType') }}">
                                                            @endif

                                                            <!-- Hidden request('categoryId') -->
                                                            @if (request('categoryId'))
                                                                <input type="hidden" name="categoryId"
                                                                    value="{{ request('categoryId') }}">
                                                            @endif
                                                            <!-- Hidden request('searchKey') -->
                                                            @if (request('searchKey'))
                                                                <input type="hidden" name="searchKey" id="hiddenSearchKey"
                                                                    value="{{ request('searchKey') }}">
                                                            @endif

                                                            <input type="submit" value="Search"
                                                                class=" btn text-white theme_color w-100">
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <form action="{{ route('user#home') }}" method="get"
                                                            id="filter-form"
                                                            class="@if (!request('searchKey')) scroll-on-submit @endif">

                                                            <!-- Hidden request('categoryId') -->
                                                            @if (request('categoryId'))
                                                                <input type="hidden" name="categoryId"
                                                                    value="{{ request('categoryId') }}">
                                                            @endif
                                                            <!-- Hidden request('searchKey') -->
                                                            @if (request('searchKey'))
                                                                <input type="hidden" name="searchKey"
                                                                    id="hiddenSearchKey"
                                                                    value="{{ request('searchKey') }}">
                                                            @endif

                                                            <!-- Hidden request('minPrice') -->
                                                            @if (request('minPrice'))
                                                                <input type="hidden" name="minPrice"
                                                                    value="{{ request('minPrice') }}">
                                                            @endif

                                                            <!-- Hidden request('maxPrice') -->
                                                            @if (request('maxPrice'))
                                                                <input type="hidden" name="maxPrice"
                                                                    value="{{ request('maxPrice') }}">
                                                            @endif

                                                            <select name="sortingType"
                                                                class="form-control w-100 bg-white mt-3">
                                                                <option value="name,asc"
                                                                    @if (request('sortingType') == 'name,asc') selected @endif>Alpha
                                                                    : A - Z</option>
                                                                <option value="name,desc"
                                                                    @if (request('sortingType') == 'name,desc') selected @endif>Alpha
                                                                    : Z - A</option>
                                                                <option value="price,asc"
                                                                    @if (request('sortingType') == 'price,asc') selected @endif>Price
                                                                    : Low - High</option>
                                                                <option value="price,desc"
                                                                    @if (request('sortingType') == 'price,desc') selected @endif>Price
                                                                    : High - Low</option>
                                                            </select>

                                                            <input type="submit" value="Sort"
                                                                class=" btn text-white theme_color my-3 w-100">
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <a href="{{ route('user#home') }}"><input type="button"
                                                                value="Clear Filter"
                                                                class=" btn text-white bg-danger my-3 w-100 clear-filter-btn"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (count($productList) != 0)
                                    <div class="col-sm-9" id="product-container">
                                        <div class="row g-4">
                                            @foreach ($productList as $item)
                                                <div class="col-lg-4 col-md-6">
                                                    <div
                                                        class="rounded position-relative fruite-item border border-secondary">
                                                        <div class="" style="overflow: hidden;">
                                                            <a
                                                                href="{{ route('user#productDetails', $item->product_id) }}"><img
                                                                    src="{{ asset('/imageProduct/' . $item->product_image) }}"
                                                                    style="height: 205px; object-fit: contain;"
                                                                    class=" w-75 rounded-top hover-zoom" loading="eager"
                                                                    alt=""></a>

                                                        </div>
                                                        @if (count($mostOrderResults) != 0)
                                                            @foreach ($mostOrderResults as $order)
                                                                @if ($order['category_id'] == $item->category_id && $order['product_id'] == $item->product_id)
                                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                                        style="top: 10px; left: 10px;"><i
                                                                            class="fa-solid fa-fire-flame-curved fs-5"></i>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        <div class="p-3 rounded-bottom text-start">
                                                            <h4 class="text-uppercase">{{ $item->product_name }}</h4>
                                                            <p style="height: 70px;">
                                                                {{ Str::words($item->description, 15, '...') }}</p>
                                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                                <p class="text-dark fs-5 fw-bold mb-0">
                                                                    {{ $item->price }}
                                                                    MMK
                                                                </p>
                                                                <a href="{{ route('user#addToCartProductId',$item->product_id) }}"
                                                                    class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                                        class="fa fa-shopping-bag me-2 text-primary"></i>
                                                                    Add
                                                                    to
                                                                    cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center text-muted h2">No Results Could Be Found.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_script')
    <script>
        document.querySelectorAll('.category-list a').forEach(link => {
            link.addEventListener('click', function() {
                sessionStorage.setItem('scrollToProduct', '1');
            });
        });

        document.querySelectorAll('form.scroll-on-submit').forEach(form => {
            form.addEventListener('submit', function() {
                sessionStorage.setItem('scrollToProduct', '1');
            });
        });

        document.querySelectorAll('.clear-filter-btn').forEach(link => {
            link.addEventListener('click', function() {
                sessionStorage.setItem('scrollToProduct', '1');
            });
        });

        // Scroll to products after reload
        window.addEventListener('DOMContentLoaded', function() {
            if (sessionStorage.getItem('scrollToProduct') === '1') {
                const productSection = document.getElementById('product-section');
                if (productSection) {
                    productSection.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
                sessionStorage.removeItem('scrollToProduct');
            }
        });
    </script>
@endsection
