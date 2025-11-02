@extends('admin.layouts.master')

@section('content')
<div class="container">
    <div class=" d-flex justify-content-between my-2">
        <div class=""></div>
        <div class="">
            <form action="{{ route('admin#salesInfoPage') }}" method="get">

                <div class="input-group">
                    <input type="text" name="searchKey" value="{{ request('searchKey') }}" class=" form-control"
                        placeholder="Enter Search Key...">
                    <button type="submit" class=" btn bg-dark text-white"> <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <span class=""><i class="fa-solid fa-triangle-exclamation text-warning p-3"></i>Click Order Code To
                See Confirmed Order Details</span>
            <table class="table table-hover shadow-sm ">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Date</th>
                        <th>Order Code</th>
                        <th>Customer Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupOrder as $items)
                        <tr>
                            <td>{{ $items[0]->created_at->format('j-F-Y') }}</td>
                            <td><a class="text-primary orderCode"
                                    href="{{ route('admin#salesInfoDetails', $items[0]->order_code) }}">{{ $items[0]->order_code }}</a>
                            </td>
                            <td>{{ $items[0]->user_name }}</td>
                            <td class="">
                                @if ($items[0]->status == 1)
                                    <i class="fa-solid fa-circle-check" style="color: #81C408;"></i>
                                @endif
                            </td>

                        </tr>
                    @endforeach

                    @if (count($groupOrder) == 0)
                            <tr>
                                <td colspan="3">
                                    <h4 class="text-muted text-center">There is no order confirmed...</h4>
                                </td>
                            </tr>
                        @endif

                </tbody>
            </table>
            {{-- @if (count($products) != 0)
            <span class=" d-flex justify-content-center">{{ $products->links() }}</span>
        @endif --}}
        </div>
    </div>
</div>
@endsection