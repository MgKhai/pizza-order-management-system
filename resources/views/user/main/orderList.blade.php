@extends('user.layouts.master')

@section('content')
<div class="container p-3 my-5">
    <div class="row p-5">
        @if (count($orderList) != 0)
        <table class="table table-hover shadow-sm ">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Date</th>
                    <th>Order Code</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($orderList as $item)
                <tr>
                    <td>{{ $item->created_at->format('j-F-Y') }}</td>
                    <td><a href="{{ route('user#orderDetails',$item->order_code) }}">{{ $item->order_code }}</a></td>
                    <td class="">
                        @if ($item->status == 0)
                        <div class="text-center w-25">
                            <span class="text-white bg-secondary px-2 py-1 rounded">Pending</span>
                        </div>
                        @elseif ($item->status == 1)
                        <div class="text-center w-25">
                            <i class="fa-solid fa-circle-check fs-3" style="color: #81C408;"></i>
                        </div>
                        @else
                        <div class="text-center w-25">
                            <i class="fa-solid fa-circle-xmark text-danger fs-3"></i>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @else
        <div class="text-center">
            <p style="font-size: 100px;"><i class="fa-solid fa-hourglass text-muted"></i></p>
            <p class="fs-2">No orders yet</p>
        </div>
        @endif
    </div>
</div>
@endsection