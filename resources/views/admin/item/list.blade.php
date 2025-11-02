@extends('admin.layouts.master')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add-on Items</h1>
    </div>

    <div class="">
        <div class="row">

            <div class="col-md-5 col">
                <div class="card mb-4">
                    <div class="card-body shadow">
                        <form action="{{ route('item#create') }}" method="post" class="p-3 rounded">

                            @csrf
                            <div class="mb-3">
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class=" form-control @error('name')
                                    is-invalid
                                @enderror "
                                    placeholder="Enter Item Name...">
                                @error('name')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input type="text" name="price" value="{{ old('price') }}"
                                    class=" form-control @error('price')
                                    is-invalid
                                @enderror "
                                    placeholder="Enter Price...">
                                @error('price')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>


                            <input type="submit" value="Create" class="btn btn-outline-primary mt-3">
                        </form>
                    </div>
                </div>
            </div>

            <div class="col">

                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Created Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($itemList as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->created_at->format('j-F-Y') }}</td>
                                <td>
                                    <a href="{{ route('item#editPage',$item->id) }}" class="btn btn-sm btn-outline-secondary"> <i
                                            class="fa-solid fa-pen-to-square"></i> </a>
                                    <button type="button" onclick="deleteProcess({{$item->id}})"
                                        class="btn btn-sm btn-outline-danger"> <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                        @if (count($itemList) == 0)
                            <tr>
                                <td colspan="6">
                                    <h5 class="text-muted text-center">There is no add-on items...</h5>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                @if (count($itemList) != 0)
                    <span class=" d-flex justify-content-center">{{ $itemList->links() }}</span>
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
                        window.location.href = '/admin/item/delete/'+$id;
                    }, 1000);
                }
            });
        }
    </script>
@endsection
