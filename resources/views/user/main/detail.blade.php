@extends('user.layouts.master')

@section('css_content')
    <style>
        .overflow-auto::-webkit-scrollbar {
            height: 6px;
        }

        .overflow-auto::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* pizza size */
        .size-option input[type="radio"] {
            display: none;
        }

        .size-option label {
            border: 2px solid transparent;
            border-radius: 10px;
            padding: 10px 16px;
            text-align: center;
            min-width: 90px;
            cursor: pointer;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            display: inline-block;
        }

        .size-option label .size-label {
            display: block;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .size-option label .size-price {
            font-weight: bold;
            color: #333;
            font-size: 0.9rem;
        }

        .size-option input[type="radio"]:checked+label {
            border-color: #ff9900;
            background-color: #fff3e0;
        }

        .size-option input[type="radio"]:checked+label .size-price {
            color: #ff6600;
        }

        .size-option input[type="radio"]:disabled+label {
            opacity: 0.5;
            pointer-events: none;
        }

        /* add-on items */
        .extra-option input[type="checkbox"] {
            display: none;
        }

        .extra-option label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
        }

        .check-icon {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            border: 2px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .check-icon svg {
            display: none;
        }

        .extra-option input[type="checkbox"]:checked+label .check-icon {
            background-color: #fff0f0;
            border-color: #ff9900;
        }

        .extra-option input[type="checkbox"]:checked+label .check-icon svg {
            display: block;
            color: #ff9900;
        }

        .extra-option input[type="checkbox"]:checked+label .ingredient {
            color: #ff9900;
            font-weight: 600;
        }

        .extra-option input[type="checkbox"]:checked+label .price {
            color: #ff9900;
            font-weight: 600;
        }

        .ingredient {
            flex-grow: 1;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="container py-5 border-secondary">
            <div class="row g-4 mb-5">
                <div class="col">
                    <a href="{{ route('user#home') }}" class="fs-5"> Home </a> <i
                        class=" mx-1 mb-4 fa-solid fa-greater-than"></i> <span class="fs-5">Details</span>
                    <div class="row g-4">
                        <div class="col-lg-3 text-center">
                            <div class="border rounded border-secondary" style="height: 370px;">

                                <img src="{{ asset('imageProduct/' . $productDetail->product_image) }}"
                                    class="img-fluid rounded h-100 w-100" style="object-fit: contain;" alt="Image">

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h3 class="fw-bold text-uppercase" style="color: #81C408;">{{ $productDetail->product_name }}
                            </h3>
                            @if ($productDetail->stock <= 5)
                                <span class="text-danger mb-3">( only {{ $productDetail->stock }} items left ! )</span>
                            @endif
                            <p class="mb-3">Category: {{ $productDetail->category_name }}</p>
                            <h5 class=" mb-3">{{ $productDetail->price }} MMK</h5>
                            <p class="mb-2">{{ $productDetail->ingredients }}</p>
                            <form action="{{ route('user#addToCart') }}" method="post">

                                @csrf
                                <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="productId" value="{{ $productDetail->product_id }}">
                                @if (Str::contains(Str::lower($productDetail->category_name), 'pizza'))
                                    <h6 class="mb-3">Size</h6>
                                    <div class="d-flex flex-wrap gap-3 mb-3">

                                        @foreach ($pizzaSize as $item)
                                            <!-- Option 1 -->
                                            <div class="size-option">
                                                <input type="radio" name="pizza_size" id="size{{ $item->id }}"
                                                    value="{{ $item->id }}"
                                                    @if (Str::contains(Str::lower($item->size), 'small')) checked @endif>
                                                <label for="size{{ $item->id }}">
                                                    <span class="size-label">{{ $item->size }}</span>
                                                    <span
                                                        class="size-price">{{ $item->price == 0 ? 'Free' : $item->price . ' mmk' }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <h6 class="mb-2">Extra Items Option</h6>
                                    <div class="row g-3">
                                        <!-- Left column -->
                                        <div class="col-md-6 mb-3">
                                            <div class="extra-option">
                                                <input type="checkbox" id="none" name="extraNone" value=""
                                                    checked>
                                                <label for="none">
                                                    <div class="check-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" fill="currentColor" class="bi bi-check"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M13.854 3.646a.5.5 0 0 1 0 .708L6.707 11.5l-4.061-4.06a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                                        </svg>
                                                    </div>
                                                    <span class="ingredient">None</span>
                                                    <span class="price"></span>
                                                </label>
                                            </div>
                                            @foreach ($addOnItems as $item)
                                                <div class="extra-option">
                                                    <input type="checkbox" id="{{ $item->name }}" name="extras[]"
                                                        value="{{ $item->id }}">
                                                    <label for="{{ $item->name }}">
                                                        <div class="check-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                                height="14" fill="currentColor" class="bi bi-check"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M13.854 3.646a.5.5 0 0 1 0 .708L6.707 11.5l-4.061-4.06a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                                            </svg>
                                                        </div>
                                                        <span class="ingredient">{{ $item->name }}</span>
                                                        <span class="price">+ {{ $item->price }} mmk</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="d-flex mb-3">
                                    <span class="fs-5">

                                        @for ($i = 1; $i <= $rating; $i++)
                                            <i class="fa-solid fa-star text-warning"></i>
                                        @endfor
                                        @for ($j = $rating + 1; $j <= 5; $j++)
                                            <i class="fa-regular fa-star text-warning"></i>
                                        @endfor

                                    </span>
                                </div>
                                <div class="input-group quantity mb-4" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" name="qty"
                                        class="form-control form-control-sm text-center border-0" value="1">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="btn border border-secondary rounded-pill px-4 py-2 mb-3 me-2 text-primary"><i
                                        class="fa fa-shopping-bag me-2text-primary"></i> Add to cart</button>


                                <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    class="btn border border-secondary rounded-pill px-4 py-2 mb-3 text-primary"><i
                                        class="fa-solid fa-star me-2 text-secondary"></i> Rate this product</button>
                            </form>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Rate this product
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('user#rating') }}" method="post">

                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="productId"
                                                value="{{ $productDetail->product_id }}">

                                            <div class="rating-css">
                                                <div class="star-icon">
                                                    @if ($userRating == 0)
                                                        <input type="radio" value="1" name="productRating"
                                                            id="rating1" checked>
                                                        <label for="rating1" class="fa fa-star"></label>

                                                        <input type="radio" value="2" name="productRating"
                                                            id="rating2">
                                                        <label for="rating2" class="fa fa-star"></label>

                                                        <input type="radio" value="3" name="productRating"
                                                            id="rating3">
                                                        <label for="rating3" class="fa fa-star"></label>

                                                        <input type="radio" value="4" name="productRating"
                                                            id="rating4">
                                                        <label for="rating4" class="fa fa-star"></label>

                                                        <input type="radio" value="5" name="productRating"
                                                            id="rating5">
                                                        <label for="rating5" class="fa fa-star"></label>
                                                    @else
                                                        @for ($i = 1; $i <= $userRating; $i++)
                                                            <input type="radio" value="{{ $i }}"
                                                                name="productRating" id="rating{{ $i }}"
                                                                @if ($i == $userRating) checked @endif>
                                                            <label for="rating{{ $i }}"
                                                                class="fa fa-star"></label>
                                                        @endfor
                                                        @for ($j = $userRating + 1; $j <= 5; $j++)
                                                            <input type="radio" value="{{ $j }}"
                                                                name="productRating" id="rating{{ $j }}">
                                                            <label for="rating{{ $j }}"
                                                                class="fa fa-star"></label>
                                                        @endfor
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Rating</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-lg-12">
                        <nav>
                            <div class="nav nav-tabs mb-3">
                                <button class="nav-link active border-white border-bottom-0 fs-5" type="button"
                                    role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                    aria-controls="nav-about" aria-selected="true">Description</button>
                                <button class="nav-link border-white border-bottom-0 fs-5" type="button" role="tab"
                                    id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                    aria-controls="nav-mission" aria-selected="false">Customer Comments <span
                                        class=" btn btn-sm btn-secondary rounded shadow-sm">{{ count($comments) }}</span>

                                </button>
                            </div>
                        </nav>
                        <div class="tab-content mb-5">
                            <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                <p>{{ $productDetail->description }}</p>
                            </div>
                            <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">


                                @foreach ($comments as $item)
                                    <div class="d-flex">
                                        <img src="{{ asset($item->profile == null ? '/default/defaultProfile.jpg' : '/profile/' . $item->profile) }}"
                                            class="img-fluid rounded-circle p-4" style="width: 100px; height: 100px;">
                                        <div class="">
                                            <p class="" style="font-size: 14px;">
                                                {{ $item->created_at->format('j-F-Y h:m') }}
                                            </p>
                                            <div class="d-flex gap-2">
                                                <h5>{{ $item->user_name }}</h5>
                                                @if ($item->user_id == Auth::user()->id)
                                                    <button type="button"
                                                        onclick="deleteProcess({{ $item->comment_id }})"
                                                        class="btn btn-sm btn-outline-danger mb-2"> <i
                                                            class="fa-solid fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            <p>{{ $item->message }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach



                            </div>
                            <div class="tab-pane" id="nav-vision" role="tabpanel">
                                <p class="text-dark">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et
                                    tempor
                                    sit. Aliqu diam
                                    amet diam et eos labore. 3</p>
                                <p class="mb-0">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos
                                    labore.
                                    Clita erat ipsum et lorem et sit</p>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('user#comment') }}" method="post">

                        @csrf
                        <input type="hidden" name="productId" value="{{ $productDetail->product_id }}">
                        <h4 class="mb-5 fw-bold">
                            Leave a Comment

                        </h4>

                        <div class="row g-1">
                            <div class="col-lg-12">
                                <div class="border-bottom rounded ">
                                    <textarea name="comment" id="review" class="form-control border-0 shadow-sm" cols="30"
                                        placeholder="Your Review *" spellcheck="false"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between py-3 mb-5">
                                    <button type="submit" id="postComment"
                                        class="btn border border-secondary text-primary rounded-pill px-4 py-3" disabled>
                                        Post
                                        Comment</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if (count($recommendProduct) > 2)
            <h4 class="mb-3 fw-bold">
                Recommended Just for You
            </h4>
            <div class="overflow-auto">
                <div class="d-flex flex-nowrap p-4">
                    @foreach ($recommendProduct as $item)
                        <div class="me-3" style="min-width: 270px; height: 400px;">

                            <div class="rounded position-relative fruite-item border border-secondary"
                                style="height: 400px;">
                                <div class="text-center" style="overflow: hidden;">
                                    <a href="{{ route('user#productDetails', $item->product_id) }}"
                                        class="text-center"><img
                                            src="{{ asset('/imageProduct/' . $item->product_image) }}"
                                            style="height: 205px; object-fit: contain;"
                                            class=" w-75 rounded-top hover-zoom" loading="eager" alt=""></a>

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
                                    <h5 class="text-uppercase">{{ $item->product_name }}</h5>
                                    <p style="height: 70px;">
                                        {{ Str::words($item->description, 15, '...') }}
                                    </p>
                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                        <p class="text-dark fs-5 fw-bold mb-0">
                                            {{ $item->price }} MMK
                                        </p>
                                        <a href="{{ route('user#addToCartProductId', $item->product_id) }}"
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
        @endif
    </div>
    </div>
@endsection

@section('js_script')
    <script>
        const reviewInput = document.getElementById('review');
        const postButton = document.getElementById('postComment');

        reviewInput.addEventListener('input', () => {
            postButton.disabled = reviewInput.value.trim() === "";
        });
    </script>

    <script>
        function deleteProcess($id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your comment has been deleted.",
                        icon: "success"
                    });

                    setInterval(() => {
                        window.location.href = '/user/comment/delete/' + $id;
                    }, 1000);
                }
            });
        }
    </script>
    <script>
        const noneCheckbox = document.getElementById('none');
        const allCheckboxes = document.querySelectorAll('input[name="extras[]"]:not(#none)');

        noneCheckbox.addEventListener('change', function() {
            if (this.checked) {
                allCheckboxes.forEach(cb => {
                    cb.checked = false;
                });
            }
        });

        allCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                if (this.checked) {
                    noneCheckbox.checked = false;
                }
            });
        });
    </script>
@endsection
