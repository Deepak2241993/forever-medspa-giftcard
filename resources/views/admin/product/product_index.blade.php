@extends('layouts.admin_layout')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h3 class="mb-0">Services List</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Services
                        </li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content-header">

    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <a href="{{ route('product.create') }}" class="btn btn-primary">Add More</a>
            <a href="{{url('/products.csv')}}" class="btn btn-info" download>Demo Download</a>
        
            <div class="card-header text-success">
                @if(session()->has('success'))
                    {{ session()->get('success') }}
                @endif
            </div>
            <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('services.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="file">Upload Bulk Data</label>
                                    <input type="file" name="file" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Import</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('product.index') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="service_name">Services Search:</label>
                                    <input type="text" class="form-control" id="service_name" name="service_name" placeholder="Service Name">
                                    <input type="hidden" class="form-control" id="user_token" name="user_token" value="{{ Auth::user()->user_token }}">
                                </div>
                                <div class="form-group col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-success w-100">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
            
            <span class="text-success">
                @if(session()->has('success'))
                    {{ session()->get('success') }}
                @endif
            </span>

            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Buy</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Actual Price</th>
                        <th>Deal Price</th>
                        <th>Product Description</th>
                        <th>Created At</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($paginator as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a class="btn btn-primary"
                                    onclick="addcart({{ $value['id'] }})">Buy</a></td>
                            <td>{{ $value['product_name'] ? $value['product_name'] : 'NULL' }}
                            </td>
                            <td>
                                @php
                                    $image = explode('|', $value['product_image']);
                                @endphp
                                {{-- @foreach ($image as $imagevalue)
                                            <img src="{{ $imagevalue }}" style="height:30px; width:30px;"> |
                    @endforeach--}}
                    <img src="{{ $image[0] }}" style="height:100px; width:100px;">
                    </td>
                    <td>{{ $value['amount'] }}</td>
                    <td>{{ $value['discounted_amount'] }}</td>
                    <td>{!! mb_strimwidth(isset($value['product_description']) ? $value['product_description'] : 'NULL',
                        0, 200, '...') !!}</td>



                    <td>{{ date('m-d-Y h:i:s', strtotime($value['created_at'])) }}
                    </td>
                    <td>
                        <a href="{{ route('product.edit', $value['id']) }}"
                            class="btn btn-primary">Edit</a>
                        <form
                            action="{{ route('product.destroy', $value['id']) }}"
                            method="POST">
                            @method('DELETE')
                            @csrf<!-- Include CSRF token for security -->
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>


                    <!-- Button trigger modal -->




                    </tr>
                    @endforeach
                </tbody>
                {{ $paginator->links() }}
            </table>
            {{ $paginator->links() }}
            <!--end::Row-->
            <!-- /.Start col -->
        </div>
        <!-- /.row (main row) -->
    </div>
    <!--end::Container-->
</section>


<!-- Modal -->
<div class="modal fade deepak" id="staticBackdrop_" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Gift Card Number</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2 id="giftcardsshow"></h2>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        function cardview(id, tid) {
            $('.deepak').attr('id', 'staticBackdrop_' + id);
            $('#staticBackdrop_' + id).modal('show');

            $.ajax({
                url: '{{ route('cardview-route') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    tid: tid,
                    user_token: '{{ Auth::user()->user_token }}',
                },
                success: function (response) {
                    if (response.success) {
                        $('#giftcardsshow').empty();
                        $.each(response.result, function (index, element) {
                            // Create a new element with the giftnumber
                            var newElement = $('<div>').html(element.giftnumber);

                            // Append the new element to #giftcardsshow
                            $('#giftcardsshow').append(newElement);
                        });

                    }
                }
            });
        }

    </script>
    <script>
        function addcart(id) {
            $.ajax({
                url: '{{ route("cart") }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: id,
                    quantity: 1
                },
                success: function (response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        $('.showbalance').html(response.error).show();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Handle the error here
                    $('.showbalance').html('An error occurred. Please try again.').show();
                }
            });
        }

    </script>
@endpush
