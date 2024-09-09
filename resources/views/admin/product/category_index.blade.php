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
                        <h3 class="mb-0">Services Deals</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Services Deals
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
                <a href="{{ route('category.create') }}" class="btn btn-primary">Add More</a>
                <form class="mt-2" method="get" action="{{ route('category.index') }}">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="cat_name">Deals Name:</label>
                            <input type="text" class="form-control" id="cat_name" name="cat_name" placeholder="Deals Name">
                            <input type="hidden" class="form-control" id="user_token" name="user_token" value="{{ Auth::user()->user_token }}">
                        </div>
                        
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-success mt-4">Search</button>
                        </div>
                    </div>
                </form>
                
                <div class="card-header text-success">
                    @if (session()->has('success'))
                        {{ session()->get('success') }}
                    @endif
                </div>
                
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Categories Name</th>
                            <th>Categories Image</th>
                            <th>Categories Description</th>
                            <th>Categories At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paginator as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value['cat_name'] ?? 'NULL' }}</td>
                                <td>
                                    @if (isset($value['cat_image']))
                                        <img src="{{ $value['cat_image'] }}" style="height:100px; width:100px;">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>{!! mb_strimwidth($value['cat_description'] ?? 'NULL', 0, 200, '...') !!}</td>
                                <td>{{ isset($value['created_at']) ? date('m-d-Y h:i:s', strtotime($value['created_at'])) : 'No Date' }}</td>
                                <td>
                                    <a href="{{ route('category.edit', $value['id']) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('category.destroy', $value['id']) }}" method="POST" style="display:inline;">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody><br>
                    {{ $paginator->links() }}
                </table>
                
                <!-- Display pagination links -->
                {{ $paginator->links() }}
                
                
                <!--end::Row-->
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>


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
                success: function(response) {
                    if (response.success) {
                        $('#giftcardsshow').empty();
                        $.each(response.result, function(index, element) {
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
@endpush
