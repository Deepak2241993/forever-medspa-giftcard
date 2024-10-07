@extends('layouts.admin_layout')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h3 class="mb-0">Services Deals</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Services Deals
                        </li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content-header">

    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div style="display: flex; align-items: center; gap: 10px;">
                <a href="{{ route('category.create') }}" class="btn btn-primary">Add More</a>
                <a href="{{url('/product_categories.csv')}}" class="btn btn-info" download="product_categories.csv">Demo Download</a>
                <form id="uploadForm" enctype="multipart/form-data" style="display: flex; align-items: center; gap: 10px;">
                        <input type="file" class="form-control" name="images[]" id="images" multiple style="width: auto;">
                        <button type="submit" class="btn btn-success">Upload Images</button>
                </form>
            </div>
            <!-- Progress Bar -->
            <div id="progressWrapper" style="display: none; margin-top: 10px;">
                <progress id="progressBar" value="0" max="100"></progress>
                <span id="progressPercentage">0%</span>
            </div>
            <!-- Display Uploaded Images -->
            <div id="uploadedImages"></div>

            <div class="card-header text-success">
                @if(session()->has('success'))
                    {{ session()->get('success') }}
                @endif
            </div>
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('categories.import') }}" method="POST" enctype="multipart/form-data">
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
                        <form method="GET" action="{{ route('category.index') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="cat_name">Deals Name:</label>
                                    <input type="text" class="form-control" id="cat_name" name="cat_name" placeholder="Deals Name">
                                    <input type="hidden" class="form-control" id="user_token" name="user_token" value="{{ Auth::user()->user_token }}">
                                </div>
                                <div class="form-group col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-success w-100">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if($paginator->isEmpty())
                    <p>No categories found.</p>
                @else
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
                    @foreach($paginator as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value['cat_name'] ?? 'NULL' }}
                            </td>
                            <td>
                                @if(isset($value['cat_image']))
                                    <img src="{{ $value['cat_image'] }}"
                                        style="height:100px; width:100px;">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>{!! mb_strimwidth($value['cat_description'] ?? 'NULL', 0, 200, '...') !!}</td>
                            <td>{{ isset($value['created_at']) ? date('m-d-Y h:i:s', strtotime($value['created_at'])) : 'No Date' }}
                            </td>
                            <td>
                                <a href="{{ route('category.edit', $value['id']) }}"
                                    class="btn btn-primary">Edit</a>
                                <form
                                    action="{{ route('category.destroy', $value['id']) }}"
                                    method="POST" style="display:inline;">
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
            @endif

            <!-- Display pagination links -->
            {{ $paginator->links() }}


            <!--end::Row-->
            <!-- /.Start col -->
        </div>
        <!-- /.row (main row) -->
    </div>
    <!--end::Container-->
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
    <!-- For Multiple Image upload Code -->

    <script>
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData();
        let files = document.getElementById('images').files;

        // Append all images to FormData
        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }

        // Append the CSRF token to FormData
        formData.append('_token', '{{ csrf_token() }}'); // This is more reliable

        let xhr = new XMLHttpRequest();

        // Update progress
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                let percentComplete = Math.round((e.loaded / e.total) * 100);
                document.getElementById('progressBar').value = percentComplete;
                document.getElementById('progressPercentage').innerText = percentComplete + '%';
                document.getElementById('progressWrapper').style.display = 'block';
            }
        });

        // On upload complete
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('progressWrapper').style.display = 'none';
                let response = JSON.parse(xhr.responseText);

                // Show uploaded images
                let uploadedImagesDiv = document.getElementById('uploadedImages');
                uploadedImagesDiv.innerHTML = ''; // Clear previous images
                response.files.forEach(file => {
                    let img = document.createElement('img');
                    img.src = '{{ url('/') }}'+ file; // Set image URL
                    // img.src = file;
                    img.style.width = '100px';
                    img.style.margin = '5px';
                    uploadedImagesDiv.appendChild(img);
                });
            }
        };

        // Error handling
        xhr.onerror = function() {
            console.log("Error during upload.");
        };

        // Open the request and send the FormData
        xhr.open('POST', '{{ url('/admin/upload-multiple-images') }}', true); 
        xhr.send(formData);  // Send the form data
    });
</script>
@endpush
