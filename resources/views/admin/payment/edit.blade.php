@extends('admin.layouts.master')

@section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Payment Edit</h1>
            </div>

            <div class="">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body shadow">
                                <div class="p-3">
                                    <a href="{{ route('payment#listPage') }}" class="btn btn-primary">Back</a>
                                </div>
                                <form action="{{ route('payment#update') }}" method="post" class="p-3 rounded">

                                    @csrf

                                    <input type="hidden" name='id' value="{{ $editPayment->id }}">

                                    <div class="mb-3">
                                        <label class="form-label">Number</label>
                                        <input type="text" name="accountNumber" value="{{ old('accountNumber',$editPayment->account_number) }}"
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
                                        <input type="text" name="accountName" value="{{ old('accountName',$editPayment->account_name) }}"
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
                                        <input type="text" name="accountType" value="{{ old('accountType',$editPayment->type) }}"
                                            class=" form-control @error('accountType')
                                            is-invalid
                                        @enderror "
                                            placeholder="Enter Account Type...">
                                        @error('accountType')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <input type="submit" value="Update" class="btn btn-outline-primary mt-3">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
@endsection