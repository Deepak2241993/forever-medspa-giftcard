@extends('layouts.admin_layout')
@section('body')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">All-Coupon</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ url('admin-dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                All-Coupon
                            </li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <a href="{{ route('coupon.create') }}" class="btn btn-primary">Add More</a>
                <div class="card-header">
                    @if (session()->has('error'))
                        {{ session()->get('error') }}
                    @endif
                    @if (session()->has('success'))
                        {{ session()->get('success') }}
                    @endif
                </div>
                @if (count($data) > 0)
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                {{-- <th>Category</th> --}}
                                <th>Discount</th>
                                <th>Code</th>
                                <th>Created At</th>
                                <th>Status</th>
                                @if (Auth::user()->user_type == 1)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($data as $key => $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->title }}</td>
                                    {{-- <td>{{$value->category_name}}</td> --}}
                                    <td>{{ $value->discount_type == 'amount' ? '$ ' . $value->discount_rate : $value->discount_rate . ' %' }}
                                    </td>
                                    <td>{{ $value->coupon_code }}</td>
                                    <td>{{ $value->created_at }}</td>
                                    <td> {{ $value->status == 1 ? 'Active' : 'Inactive' }}</td>
                                    <th>
                                        <a href="{{ route('coupon.edit', $value->id) }}" class="btn btn-primary">Edit</a>

                                        <form action="{{ route('coupon.destroy', $value->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf <!-- Include CSRF token for security -->
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>



                                    </th>


                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p> No data found</p>
                @endif
                <!--end::Row-->
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection
