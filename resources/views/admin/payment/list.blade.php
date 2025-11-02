@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Payment Information</h1>
        </div>

        <div class="">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route('payment#create') }}" method="post" class="p-3 rounded">

                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Number</label>
                                    <input type="text" name="accountNumber" value="{{ old('accountNumber') }}"
                                        class=" form-control @error('accountNumber')
                                        is-invalid
                                    @enderror "
                                        placeholder="Enter Account Number...">
                                    @error('accountNumber')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="accountName" value="{{ old('accountName') }}"
                                        class=" form-control @error('accountName')
                                        is-invalid
                                    @enderror "
                                        placeholder="Enter Account Name...">
                                    @error('accountName')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Type</label>
                                    <input type="text" name="accountType" value="{{ old('accountType') }}"
                                        class=" form-control @error('accountType')
                                        is-invalid
                                    @enderror "
                                        placeholder="Enter Account Type...">
                                    @error('accountType')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>


                                <input type="submit" value="Create" class="btn btn-outline-primary mt-3">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col ">
                    <table class="table table-hover shadow-sm ">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>AccountNumber</th>
                                <th>Type</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($paymentList as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->account_name }}</td>
                                    <td>{{ $item->account_number }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>
                                        <a href="{{ route('payment#editPage',$item->id) }}" class="btn btn-sm btn-outline-secondary"> <i
                                                class="fa-solid fa-pen-to-square"></i> </a>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteProcess({{$item->id}})"> <i
                                                class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                            @if (count($paymentList) == 0)
                                <tr>
                                    <td colspan="5">
                                        <h5 class="text-muted text-center">There is no payment information...</h5>
                                    </td>
                                </tr>
                            @endif


                        </tbody>
                    </table>

                    @if (count($paymentList) != 0)
                        <span class=" d-flex justify-content-center">{{ $paymentList->links() }}</span>
                    @endif

                </div>
            </div>
        </div>

    </div>
@endsection

@section('js_script')
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
                        text: "Your file has been deleted.",
                        icon: "success"
                    });

                    setInterval(() => {
                        window.location.href = '/admin/payment/delete/'+$id;
                    }, 1000);
                }
            });
        }
    </script>
@endsection
