@extends('user.layouts.master')

@section('content')
    <!-- Cart Page Start -->
    <div class="container-fluid py-4 mt-2">
        <div class="container py-5">
            @if (count($groupCart) != 0)
                <div class="table-responsive">
                    <table class="table" id="productTable">
                        <thead>
                            <tr>
                                <th scope="col">Products</th>
                                <th scope="col">Name</th>
                                <th scope="col"></th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($groupCart as $items)
                                <tr>
                                    <td scope="row">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('/imageProduct/' . $items[0]->product_image) }}"
                                                class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;"
                                                alt="">
                                        </div>
                                    </td>
                                    <td style="width: 120px;">
                                        <p class="mb-0 mt-4">{{ $items[0]->product_name }}</p>
                                        <input type="hidden" class="size_price" value="{{ $items[0]->size_price }}">
                                        <input type="hidden" class="sizeId" value="{{ $items[0]->size_id }}">
                                        <input type="hidden" class="addon_total" value="{{ $items[0]->addon_total }}">
                                    </td>
                                    <td style="width: 200px;">
                                        <p class="mb-0 mt-4">
                                            @if ($items[0]->pizza_size != null)
                                                <span class="d-flex justify-content-between w-100 align-items-center">
                                                    @if ($items[0]->size_price != null)
                                                        <small class="">+ {{ $items[0]->size_price }} mmk
                                                            ({{ $items[0]->pizza_size }})
                                                        </small>
                                                    @else
                                                        <small class="">+ free ({{ $items[0]->pizza_size }})</small>
                                                    @endif
                                                </span>
                                            @endif
                                            @foreach ($items as $item)
                                                @if ($item->addon_name != null)
                                                    <span class="d-flex justify-content-between w-100 align-items-center">
                                                        <small class="">+ {{ $item->addon_price }} mmk
                                                            ({{ $item->addon_name }})
                                                        </small>
                                                        <small class="addonIdList">
                                                            <input type="hidden" class="addonId"
                                                                value="{{ $item->addon_id }}">
                                                        </small>
                                                    </span>
                                                @else
                                                    {{-- <p class=" text-center w-75 mb-0 mt-4"><i class="fa-solid fa-minus"></i></p> --}}
                                                @endif
                                            @endforeach
                                            {{-- </ul> --}}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4 price">{{ $items[0]->price }} mmk</p>
                                    </td>
                                    <td>
                                        <div class="input-group quantity mt-4" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button
                                                    class="btn btn-sm btn-minus rounded-circle bg-light border btn-minus">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text"
                                                class="form-control qty form-control-sm text-center border-0"
                                                value="{{ $items[0]->qty }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-plus rounded-circle bg-light border btn-plus">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4 total">
                                            {{ ($items[0]->price + $items[0]->size_price + $items[0]->addon_total) * $items[0]->qty }}
                                            mmk</p>
                                    </td>
                                    <td>
                                        <input type="hidden" class="cartId" value="{{ $items[0]->cart_id }}">
                                        <input type="hidden" class="productId" value="{{ $items[0]->product_id }}">
                                        <input type="hidden" class="userId" value="{{ Auth::user()->id }}">
                                        <button class="btn btn-md rounded-circle bg-light border mt-4 btn-remove">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center">
                    <h1>Your cart is empty !</h1>
                    <a href="{{ route('user#home') }}"
                        class="my-3 btn border border-secondary rounded-pill px-3 text-primary fs-4">Continue Shopping</a>
                </div>
            @endif
            <div class="row g-4 justify-content-end">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4">
                            <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Subtotal:</h5>
                                <p class="mb-0" id="subtotal">{{ $total }} mmk</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 me-4">Delivery </h5>
                                <div class="">
                                    <p class="mb-0"> 3500 mmk </p>
                                </div>
                            </div>
                        </div>
                        <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                            <h5 class="mb-0 ps-4 me-4">Total</h5>
                            <p class="mb-0 pe-4 " id="finalTotal">{{ $total + 3500 }} mmk</p>
                        </div>
                        <button id="btn-checkout"
                            class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4 @if (count($groupCart) == 0) disabled @endif"
                            type="button">Proceed Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->
@endsection

@section('js_script')
    <script>
        $(document).ready(function() {
            $('.btn-minus').click(function() {
                countCalculation(this)
                finalTotalCalculation();
            })

            $('.btn-plus').click(function() {
                countCalculation(this);
                finalTotalCalculation();
            })

            function countCalculation(event) {
                parnetNode = $(event).parents("tr");

                product_price = Number(parnetNode.find(".price").text().replace('mmk', ''));
                size_price = Number(parnetNode.find(".size_price").val());
                addon_total = Number(parnetNode.find(".addon_total").val());
                qty = parnetNode.find('.qty').val();

                parnetNode.find('.total').text((product_price + size_price + addon_total) * qty +
                    ' mmk');
            }

            function finalTotalCalculation() {
                total = 0;

                $("#productTable tbody tr").each(function(index, item) {
                    total += $(item).find(".total").text().replace("mmk", "") * 1;
                })

                $("#subtotal").html(`${total} mmk`);
                $("#finalTotal").html(`${total+1000} mmk`);
            }

            $(".btn-remove").click(function() {
                parentNode = $(this).parents("tr");
                cartId = parentNode.find(".cartId").val();

                deleteData = {
                    'cartId': cartId
                };

                $.ajax({
                    type: 'get',
                    url: '/user/cart/delete',
                    data: deleteData,
                    dataType: 'json',
                    success: function(res) {
                        res.status == 'success' ? location.reload() : ''
                    },
                    error: function() {
                        console.log('error...');
                    }
                });


            })

            $('#btn-checkout').click(function() {
                userId = $('.userId').val();
                orderCode = 'PJ-POS-' + Math.floor(Math.random() * 100000000000);
                finalTotal = $('#finalTotal').text().replace('mmk','');

                orderList = [];
                $("#productTable tbody tr").each(function(index, row) {
                    productId = $(row).find('.productId').val();
                    qty = $(row).find('.qty').val();
                    sizeId = $(row).find('.sizeId').val();
                    cartId = $(row).find('.cartId').val();

                    addonIdList = [];
                    $(row).find('.addonIdList').each(function(index, item) {
                        addonId = $(item).find('.addonId').val();
                        addonIdList.push(addonId);
                    })

                    orderList.push({
                        'user_id': userId,
                        'product_id': productId,
                        'cart_id' : cartId,
                        'count': qty,
                        'size_id': sizeId,
                        'status': 0,
                        'order_code': orderCode,
                        'addon_id': addonIdList,
                        'final_total' : finalTotal
                    });
                })

                $.ajax({
                    type: 'get',
                    url: '/user/tempStorage',
                    data: Object.assign({},orderList),
                    dataType: 'json',
                    success : function(res){
                        res.status == 'success' ? location.href = '/user/payment': location.reload();
                    }
                });

            })


        })
    </script>
@endsection
