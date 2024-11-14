@extends('layouts.admin_layout')
@section('body')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="mb-0">Service Unit</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Service Unit
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
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <!-- Add More Button (Left Side) -->
                    <a href="{{ route('unit.create') }}" class="btn btn-dark mb-4">Add More</a>

                    <!-- Form and Demo Download (Right Side) -->

                </div>
                <!-- Display Uploaded Images -->

                @if (session('message'))
                    <div class="alert alert-success mt-4">
                        {{ session('message') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
          
            
                
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Unit Name</th>
                            <th>Orignal Price</th>
                            <th>Discounted Price</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $value->product_name ? $value->product_name: 'N/A' }}
                                </td>
                                <td>{{ $value->amount }}</td>
                                <td>{{ $value->discounted_amount }}</td>
                                <td>{{ $value->status == 1 ?  "Active":"Inactive" }}</td>
                                

                                <td>{{ date('m-d-Y h:i:s', strtotime($value['created_at'])) }}</td>
                                <td>
                                    <a href="{{ route('unit.edit', $value['id']) }}" class="btn btn-primary">Edit</a>
                                    <a href="{{ route('unitdelete', $value['id']) }}" class="btn btn-danger">Delete</a>
                                  
                                </td>


                                <!-- Button trigger modal -->




                            </tr>
                        @endforeach
                    </tbody>
                    {{ $result->links() }}
                </table>
                {{ $result->links() }}
                <!--end::Row-->
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </section>

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
    <script>
        function addcart(id) {
            $.ajax({
                url: '{{ route('cart') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: id,
                    quantity: 1
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        $('.showbalance').html(response.error).show();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle the error here
                    $('.showbalance').html('An error occurred. Please try again.').show();
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
            formData.append('_token', '{{ csrf_token() }}');

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
                document.getElementById('progressWrapper').style.display = 'none';

                if (xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);

                    // Clear previous errors and images
                    document.getElementById('validationErrors').innerHTML = '';
                    document.getElementById('uploadedImages').innerHTML = '';

                    // Show successfully uploaded images
                    if (response.files.length > 0) {
                        let uploadedImagesDiv = document.getElementById('uploadedImages');
                        response.files.forEach(file => {
                            let img = document.createElement('img');
                            img.src = '{{ url('/') }}' + file;
                            img.style.width = '100px';
                            img.style.margin = '5px';
                            uploadedImagesDiv.appendChild(img);
                        });
                    }

                    // Show validation errors
                    if (response.errors.length > 0) {
                        let errorDiv = document.getElementById('validationErrors');
                        response.errors.forEach(error => {
                            let errorItem = document.createElement('div');
                            errorItem.className = 'alert alert-danger';
                            errorItem.innerText = error;
                            errorDiv.appendChild(errorItem);
                        });
                    }
                } else {
                    console.log("Error during upload.");
                }
            };

            // Error handling
            xhr.onerror = function() {
                console.log("Error during upload.");
            };

            // Open the request and send the FormData
            xhr.open('POST', '{{ url('/admin/upload-multiple-images') }}', true);
            xhr.send(formData);
        });
    </script>
    <script>
        function Copy(getkey) {
            // Get the button element using its unique id
            var copyButton = document.getElementById("copy_url_" + getkey);

            // Get the URL from the 'url_link' attribute
            var url = copyButton.getAttribute("url_link");

            // Use the modern clipboard API to copy the URL
            navigator.clipboard.writeText(url).then(function() {
                $('#copy_url_' + getkey).val('Copied')
                // alert("URL copied to clipboard: " + url);
            }).catch(function(error) {
                console.error("Could not copy text: ", error);
            });
        }
    </script>
@endpush
