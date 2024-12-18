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
            <div style="display: flex; justify-content: space-between; align-items: center;">
    <!-- Add More Button (Left Side) -->
            <a href="{{ route('product.create') }}" class="btn btn-dark">Add More</a>

            <!-- Form and Demo Download (Right Side) -->
            <div style="display: flex; align-items: center; gap: 10px;">
                @if($paginator->isEmpty())
                <a href="{{url('/services.csv')}}" class="btn btn-info" download="services.csv">Download Service Template</a>
                @else
                <a href="{{url('/admin/export-services')}}" class="btn btn-info" download="services.csv">Download Service Template</a>
                @endif
                <a href="{{url('/admin/export-categories')}}" class="btn btn-warning" download="deals.csv">Download Deals Data</a>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#media_modal">
                    Media
                  </button>
            </div>
        </div>
<!-- Display Uploaded Images -->

@if (session('success'))
<div class="alert alert-success mt-4">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger mt-4">
    {{ session('error') }}
    @if (session('details'))
        <pre>{{ session('details') }}</pre>
    @endif
</div>
@endif
@if (session('import_errors') && count(session('import_errors')) > 0)
<div class="alert alert-danger mt-4">
    <h4>There were some errors while importing the data:</h4>

    <ul>
        @foreach (session('import_errors') as $errorDetail)
            <li>
                <strong>Row:</strong>
                <pre>{{ print_r($errorDetail['row'], true) }}</pre>
                <strong>Errors:</strong>
                <ul>
                    @foreach ($errorDetail['errors'] as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </li>
            <li> <a href="{{ route('clear.errors') }}" class="btn btn-danger">Clear Errors</a></li>
        @endforeach
    </ul>
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
            <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('services.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="file">Upload Bulk Service Data</label>
                                    <input type="file" name="file" class="form-control" accept=".csv" required>
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
                        <th>Type</th>
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
                    <img src="{{ $image[0] }}" style="height:100px; width:100px;" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                    </td>
                    <td>{{ $value['amount'] }}</td>
                    <td>{{ $value['discounted_amount'] }}</td>
                    <td>{!! mb_strimwidth(htmlspecialchars(isset($value['short_description']) ? $value['short_description'] : 'NULL'), 0, 100, '...') !!}</td>




                    <td>{{$value['unit_id']!=null ? "Unit Service":"Normal Deals & Service"}}
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
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <h2 id="giftcardsshow"></h2>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal for Media Upload --}}

  <!-- Modal -->
  <div class="modal fade" id="media_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="media_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="media_modalLabel">Media Upload</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div id="validationErrors"></div>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form id="uploadForm" enctype="multipart/form-data"
                            style="display: flex; align-items: center; gap: 10px;">
                            <input type="file" class="form-control" name="images[]" id="images" multiple
                                style="width: auto;" required accept="image/jpg, image/jpeg, image/png" />
                            <button type="submit" class="btn btn-success">Upload Images</button>
                        </form>
                        <!-- Display Uploaded Images -->
                        <div id="progressWrapper" style="display: none; margin-top: 10px;">
                            <progress id="progressBar" value="0" max="100"></progress>
                            <span id="progressPercentage">0%</span>
                        </div>
                        <div id="uploadedImages"></div>
                        <!-- Display Uploaded Images -->
        </div>
        <div class="modal-footer">
            {{-- <button class="btn btn-warning" onclick="window.location.reload();">Refresh</button> --}}
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <div class="row">
                    @foreach ($images as $key => $image)
                        <div class="col-md-2 mb-4 image-container" data-image="{{ $image }}" style="position: relative;">
                            <div class="border border-primary" style="height:100px;width:120px;margin-top: 30px; position:relative;">
                                <img src="{{ url('/') }}{{ Storage::url($image) }}" class="img-fluid" alt="Image" style="height:100px;width:120px;" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                                <button type="button" class="rounded-circle btn-close delete-image text-danger" aria-label="Close" style="position: absolute; top: -23px; right: -24px; background: transparent; border: 1px; font-size: 20px;"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                
                                <!-- Copy URL Button -->
                                <input type="button" class="form-control btn btn-success mt-1 mb-2" id="copy_url_{{ $key }}" url_link="{{ url('/') }}{{ Storage::url($image) }}" value="Copy URL" onclick="Copy({{ $key }});" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  {{-- Modal Media Code End --}}
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
                    quantity: 1,
                    type: "product"
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

    <!-- For Multiple Image upload Code -->
    <script>
        document.getElementById('uploadForm').addEventListener('submit', function (e) {
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
xhr.upload.addEventListener('progress', function (e) {
    if (e.lengthComputable) {
        let percentComplete = Math.round((e.loaded / e.total) * 100);
        document.getElementById('progressBar').value = percentComplete;
        document.getElementById('progressPercentage').innerText = percentComplete + '%';
        document.getElementById('progressWrapper').style.display = 'block';
    }
});

// On upload complete
xhr.onload = function () {
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
xhr.onerror = function () {
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
            $('#copy_url_'+getkey).val('Copied')
            // alert("URL copied to clipboard: " + url);
        }).catch(function(error) {
            console.error("Could not copy text: ", error);
        });
    }    
    </script>

@endpush
