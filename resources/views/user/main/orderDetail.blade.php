@extends('user.layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row p-5">
            <a class="text-primary" href="{{ route('user#orderListPage') }}" class=" text-black m-3"> <i
                    class="fa-solid fa-arrow-left-long"></i>
                Back</a>

            <!-- DataTales Example -->
            <div class="my-3">
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
                                        <th>Product Price (each)</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($groupOrder as $items)
                                        <tr>
                                            {{-- <input type="hidden" name="" class="productId" value="{{ $items[0]->product_id }}">
                                        <input type="hidden" name="" class="count" value="{{ $items[0]->count }}"> --}}
                                            <td>
                                                <img src="{{ asset('/imageProduct/' . $items[0]->product_image) }}"
                                                    class=" img-thumbnail" style="height: 50px; width: 50px;">
                                            </td>
                                            <td>{{ $items[0]->product_name }}</td>
                                            <td>
                                                <p class="">
                                                    @if ($items[0]->pizza_size != null)
                                                        <span
                                                            class="d-flex justify-content-between w-100 align-items-center">
                                                            @if ($items[0]->size_price != null)
                                                                <small class="">+ {{ $items[0]->size_price }} mmk
                                                                    ({{ $items[0]->pizza_size }})
                                                                </small>
                                                            @else
                                                                <small class="">+ free
                                                                    ({{ $items[0]->pizza_size }})</small>
                                                            @endif
                                                        </span>
                                                    @endif
                                                    @foreach ($items as $item)
                                                        @if ($item->addon_name != null)
                                                            <span
                                                                class="d-flex justify-content-between w-100 align-items-center">
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
                                            <td>{{ $items[0]->count }}
                                            </td>

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
                </div>
            </div>
        </div>

    </div>
@endsection
