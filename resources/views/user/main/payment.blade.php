@extends('user.layouts.master')

@section('content')
    <div class="container my-5 p-5">
        <div class="row">
            <div class="col-12">

                <div class="row">
                    <div class="col-5">
                        <h5 class="mb-4">Payment methods</h5>

                        @foreach ($paymentAcc as $item)
                            <div class="">
                                <b>{{ $item->type }}</b> ( Name : {{ $item->account_name }})
                            </div>

                            Account : {{ $item->account_number }}

                            <hr>
                        @endforeach
                    </div>
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                Payment Info
                            </div>
                            <div class="card-body">
                                <div class="">
                                    <form action="{{ route('user#order') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mt-4">
                                            <div class="col">
                                                <input type="text" name="name" id="" readonly
                                                    value="{{ Auth::user()->name }}" class="form-control "
                                                    placeholder="User Name...">
                                            </div>
                                            <div class="col">
                                                <input type="text" name="phone" id=""
                                                    value="{{ old('phone') }}"
                                                    class="form-control @error('phone')
                                                            is-invalid
                                                        @enderror "
                                                    placeholder="Enter Phone Number...">
                                                @error('phone')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col">
                                                <textarea name="address" id="" rows="5" cols="30"
                                                    class="form-control @error('address')
                                                        is-invalid
                                                    @enderror"
                                                    placeholder="Enter Address...">{{ old('address') }}</textarea>
                                                @error('address')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col">
                                                <select name="paymentType" id=""
                                                    class=" form-select @error('paymentType')
                                                        is-invalid
                                                    @enderror ">
                                                    <option value="">Choose Payment methods...</option>
                                                    @foreach ($paymentAcc as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if (old('paymentType') == $item->id) selected @endif>
                                                            {{ $item->type }}</option>
                                                    @endforeach

                                                </select>
                                                @error('paymentType')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <input type="file" name="payslipImage" id="" accept="image/*"
                                                    class="form-control @error('payslipImage')
                                                            is-invalid
                                                        @enderror">
                                                @error('payslipImage')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col">
                                                <input type="hidden" name="orderCode"
                                                    value="{{ $tempOrder[0]['order_code'] }}">
                                                Order Code : <span
                                                    class="text-secondary">{{ $tempOrder[0]['order_code'] }}</span>
                                            </div>
                                            <div class="col">
                                                <input type="hidden" name="totalAmount"
                                                    value="{{ $tempOrder[0]['final_total'] }}">
                                                Total Amount : <span class=" ">{{ $tempOrder[0]['final_total'] }}
                                                    mmk</span>
                                            </div>
                                        </div>

                                        <div class="row mt-4 mx-2">
                                            <button type="submit"
                                                class="btn border border-secondary rounded-pill px-4 py-2 mb-3 me-2 text-primary"><i
                                                    class="fa-solid fa-cart-shopping me-3"></i> Order Now</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
