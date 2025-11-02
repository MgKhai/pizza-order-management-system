@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <a class="text-primary" href="{{ route('admin#orderListPage') }}" class=" text-black m-3"> <i
                class="fa-solid fa-arrow-left-long"></i>
            Back</a>

        <!-- DataTales Example -->


        <div class="row">
            <div class="col-lg-5 m-4">
                <div class="card">
                    <div class="card-header  bg-primary text-white">Customer Information</div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-3">Name : </div>
                            <div class="col">{{ $userProfileData->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Phone :</div>
                            <div class="col">
                                {!! $userProfileData->profile_phone == null
                                    ? '<span class="p-3"><i class="fa-solid fa-minus"></i></span>'
                                    : $userProfileData->profile_phone !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Addr : </div>
                            <div class="col-7">
                                {!! $userProfileData->profile_address == null
                                    ? '<span class="p-3"><i class="fa-solid fa-minus"></i></span>'
                                    : $userProfileData->profile_address !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Order Code :</div>
                            <div class="col" id="orderCode">{{ $paymentInfo->order_code }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Order Date : </div>
                            <div class="col">{{ $paymentInfo->created_at->format('j-F-Y') }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Total Price : </div>
                            <div class="col">
                                {{ $paymentInfo->total_amt }} mmk <br><small class=" text-danger ms-1">( Contain Delivery
                                    Charges )</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" col-lg-5 m-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Payment Information
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-4">Contact Phone :</div>
                            <div class="col"> {{ $paymentInfo->phone }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">Contact Address :</div>
                            <div class="col"> {{ $paymentInfo->address }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">Payment Method : </div>
                            <div class="col">{{ $paymentInfo->type }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">Purchase Date : </div>
                            <div class="col">{{ $paymentInfo->created_at->format('j-F-Y') }}</div>
                        </div>
                        <div class="row mb-3 p-2">
                            <img style="width: 150px" src="{{ asset('/payslipImage/' . $paymentInfo->payslip_image) }}"
                                class=" img-thumbnail">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Order Board</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm " id="productTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="col-2">Image</th>
                                <th>Name</th>
                                <th></th>
                                <th>Order Count</th>
                                <th>Available Stock</th>
                                <th>Product Price (each)</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($groupOrder as $items)
                                <tr>
                                    <input type="hidden" name="" class="productId" value="{{ $items[0]->product_id }}">
                                    <input type="hidden" name="" class="count" value="{{ $items[0]->count }}">
                                    <td>
                                        <img src="{{ asset('/imageProduct/' . $items[0]->product_image) }}"
                                            class=" img-thumbnail" style="height: 50px; width: 50px;">
                                    </td>
                                    <td>{{ $items[0]->product_name }}</td>
                                    <td>
                                        <p class="">
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
                                                        {{-- <small class="addonIdList">
                                                            <input type="hidden" class="addonId"
                                                                value="{{ $item->addon_id }}">
                                                        </small> --}}
                                                    </span>
                                                @else
                                                    {{-- <p class=" text-center w-75 mb-0 mt-4"><i class="fa-solid fa-minus"></i></p> --}}
                                                @endif
                                            @endforeach
                                            {{-- </ul> --}}
                                        </p>
                                    </td>
                                    <td>{{ $items[0]->count }} @if ($items[0]->count > $items[0]->stock)
                                            <small class="text-danger">(out of stock)</small>
                                        @endif
                                    </td>
                                    <td>{{ $items[0]->stock }}</td>
                                    <td>{{ $items[0]->product_price }} mmk</td>
                                    <td>{{ ($items[0]->product_price + $items[0]->size_price + $items[0]->addon_total) * $items[0]->count }}
                                        mmk</td>
                                </tr>
                            @endforeach


                        </tbody>
                        {{-- <input type="hidden" class="productId" value="">
                                <input type="hidden" class="productOrderCount" value=""> --}}

                    </table>

                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <div class="">
                    @if ($stockCheck)
                        <input type="button" id="btn-order-confirm" class="btn btn-success rounded shadow-sm"
                            value="Confirm">
                    @endif
                    <input type="button" id="btn-order-reject" class="btn btn-danger rounded shadow-sm" value="Reject">
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js_script')
    <script>
        $(document).ready(function() {
            $('#btn-order-reject').click(function() {
                orderCode = $('#orderCode').text();

                data = {
                    'orderCode': orderCode
                };

                $.ajax({
                    type: 'get',
                    url: '/admin/order/reject',
                    data: data,
                    dataType: 'json',
                    success: function(res) {
                        res.status == 'success' ? location.href = '/admin/order/list' : '';
                    }
                });
            })

            $('#btn-order-confirm').click(function() {
                orderCode = $('#orderCode').text();
                orderList = [];

                $('#productTable tbody tr').each(function(index,row){
                    productId = $(row).find('.productId').val();
                    productCount = $(row).find('.count').val();

                    orderList.push({
                        'orderCode' : orderCode,
                        'productId' : productId,
                        'productCount' : productCount
                    });
                })

                $.ajax({
                    type: 'get',
                    url: '/admin/order/confirm',
                    data: Object.assign({},orderList),
                    dataType: 'json',
                    success: function(res) {
                        res.status == 'success' ? location.href = '/admin/order/list' : '';
                    }
                });
            })
        })
    </script>
@endsection
