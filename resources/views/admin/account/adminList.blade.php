@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <a href="{{ route('account#userListPage') }}"> <button class=" btn btn-sm btn-secondary  "> User List</button> </a>
            <div class="">
                <form action="{{ route('account#adminListPage') }}" method="get">

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
                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Created Date</th>
                            <th> Platform</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($adminList as $item)
                            <tr>
                                <td><img class="rounded" style="height: 100px; width: 100px; object-fit: cover;"
                                        src="{{ asset($item->profile == null ? '/default/defaultProfile.jpg' : '/profile/' . $item->profile) }}">
                                </td>
                                <td>{{ $item->name != null ? $item->name : $item->nickname }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{!! $item->address != null ? $item->address : '<i class="fa-solid fa-minus"></i>' !!}</td>
                                <td>{!! $item->phone != null ? $item->phone : '<i class="fa-solid fa-minus"></i>' !!}</td>
                                <td><span
                                        class="btn btn-sm bg-danger text-white rounded shadow-sm">{{ $item->role }}</span>
                                </td>

                                <td>{{ $item->created_at->format('j-F-Y') }}</td>
                                <td>
                                    {{ $item->provider }}
                                </td>
                                <td>
                                    @if ($item->role == 'admin')
                                        <button onclick="deleteProcess({{ $item->id }})"
                                            class="btn btn-sm btn-outline-danger"> <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        @if (count($adminList) == 0)
                            <tr>
                                <td colspan="8">
                                    <h5 class="text-muted text-center">There is no data...</h5>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>

                @if (count($adminList) != 0)
                    <span class=" d-flex justify-content-center">{{ $adminList->links() }}</span>
                @endif

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
                        window.location.href = '/admin/account/adminlist/delete/'+$id;
                    }, 1000);
                }
            });
        }
    </script>
@endsection
