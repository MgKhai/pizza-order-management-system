@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div class=""></div>
            <div class="">
                <form action="{{ route('admin#orderListPage') }}" method="get">

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
                    See Order Details</span>
                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Date</th>
                            <th>Order Code</th>
                            <th>Customer Name</th>
                            <th>Action</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupOrder as $items)
                            <tr>
                                <td>{{ $items[0]->created_at->format('j-F-Y') }}</td>
                                <td><a class="text-primary orderCode"
                                        href="{{ route('admin#orderDetails', $items[0]->order_code) }}">{{ $items[0]->order_code }}</a>
                                </td>
                                <td>{{ $items[0]->user_name }}</td>
                                <td>
                                    <select name="" class="statusChange" id="">
                                        <option value="0" @if ($items[0]->status == 0) selected @endif>Pending
                                        </option>
                                        @if ($items[0]->stock_check)
                                            <option value="1" @if ($items[0]->status == 1) selected @endif>Accept
                                            </option>
                                        @endif
                                        <option value="2" @if ($items[0]->status == 2) selected @endif>Reject
                                        </option>
                                    </select>
                                </td>

                                <td class="">
                                    @if ($items[0]->status == 0)
                                        <i class="fa-solid fa-hourglass-start text-warning"></i>
                                    @elseif ($items[0]->status == 1)
                                        <i class="fa-solid fa-circle-check" style="color: #81C408;"></i>
                                    @else
                                        <i class="fa-solid fa-circle-xmark text-danger"></i>
                                    @endif
                                </td>

                                @if ($items[0]->status == 2)
                                    <td>
                                        <button onclick="deleteProcess('{{$items[0]->order_code}}')" class="btn btn-sm btn-outline-danger"> <i
                                                class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                @else
                                <td></td>
                                @endif


                            </tr>
                        @endforeach

                        @if (count($groupOrder) == 0)
                            <tr>
                                <td colspan="5">
                                    <h4 class="text-muted text-center">There is no order...</h4>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>
                {{-- @if (count($groupOrder) != 0)
                <span class=" d-flex justify-content-center">{{ $products->links() }}</span>
            @endif --}}
            </div>
        </div>
    </div>
@endsection

@section('js_script')
    <script>
        function deleteProcess($orderCode) {
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
                        text: "Your file has been deleted.",
                        icon: "success"
                    });

                    setInterval(() => {
                        window.location.href = '/admin/order/delete/' + $orderCode;
                    }, 1000);
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.statusChange').change(function() {
                orderCode = $(this).parents('tr').find('.orderCode').text();
                status = $(this).val();

                data = {
                    'orderCode': orderCode,
                    'status': status
                };

                $.ajax({
                    type: 'get',
                    url: '/admin/order/status/change',
                    data: data,
                    dataType: 'json',
                    success: function(res) {
                        res.status == 'success' ? location.reload() : '';
                    }
                });
            })
        })
    </script>
@endsection
