@extends('layouts.admin_layout')
@section('body')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Program Create/Update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/root') }}">Home</a></li>
                        <li class="breadcrumb-item active">Program Create/Update</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content-header">

        <!--begin::App Content Header-->
        @if ($errors->has('image'))
            <div class="alert alert-danger">
                {{ $errors->first('image') }}
            </div>
        @endif
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="card-body p-4">
                    @if (isset($banner))
                        <form method="post" action="{{ route('program.update', $banner->id) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                        @else
                            <form method="post" action="{{ route('program.store') }}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="row">
                        <!-- Title -->
                        <div class="mb-3 col-lg-6">
                            <label for="title" class="form-label">Program Name</label>
                            <input class="form-control" type="text" name="program_name"
                                value="{{ isset($banner) ? $banner->title : '' }}" placeholder="Program Name">
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label for="title" class="form-label">Program Description</label>
                            <textarea class="form-control" name="description">  </textarea>
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="url" class="form-label">Selling Price</label>
                            <input class="form-control" id="url" type="number" name="selling_price" min="0"
                                value="{{ isset($banner) ? $banner->url : '' }}" placeholder="Selling Price" required>
                        </div>
                        <div class="mb-3 col-lg-12">
                            <label for="title" class="form-label">Terms And Conditions</label>
                            <textarea class="form-control summernote" name="description">  </textarea>
                        </div>
                        <!-- Status -->
                        <div class="mb-3 col-lg-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1"
                                    {{ isset($banner->status) && $banner->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0"
                                    {{ isset($banner->status) && $banner->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Radio Buttons for Deals/Services -->
                        {{-- <div class="mb-3 col-lg-6">
            <label class="form-label">Select Type</label><br>
            <input type="radio" name="type" value="1" id="dealsRadio" onclick="toggleSelectOptions()" required> Unit
            <input type="radio" name="type" value="2" id="servicesRadio" onclick="toggleSelectOptions()" required> Service
        </div> --}}

                        <!-- Deals Select Option (Initially Hidden) -->
                        {{-- <div class="mb-3 col-lg-6" id="dealsSelect" style="display: none;">
            <label for="deals" class="form-label">Select Unit</label>
            <select class="form-control" name="deals_and_service" id="deals" onchange="seturl('unit')">
                <option value="">Select Unit</option>
                @foreach ($unit as $value)
                <option value="{{$value->product_slug}}">{{$value->product_name}}</option>
                @endforeach
                <!-- Add more deals as needed -->
            </select>
        </div> --}}

                        <!-- Services Select Option (Initially Hidden) -->
                        {{-- <div class="mb-3 col-lg-6" id="servicesSelect" style="display: none;">
            <label for="services" class="form-label">Select Services</label>
            <select class="form-control" name="deals_and_service" id="services" onchange="seturl('services')">
            <option value="">Select Service</option>
            @foreach ($services as $value)
                <option value="{{$value->product_slug}}">{{$value->product_name}}</option>
                @endforeach
                <!-- Add more services as needed -->
            </select>
        </div> --}}

                        <!-- Submit Button -->
                        
                        <div class="mb-3 col-lg-12">
                            <button  class="btn btn-block btn-outline-primary" type="submit" name="submit">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
                <!--end::Row-->
                <!-- /.Start col -->
            </div>
            <!-- /.row (section row) -->
        </div>
        <!--end::Container-->
        </div>
        <!--end::App Content-->
    </section>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300, // Set height of the editor
            width: 860, // Set width of the editor
            focus: true, // Focus the editor on load
            fontSizes: ['8', '9', '10', '11', '12', '14', '18', '22', '24', '36', '48', '64', '82', '150'], // Font sizes
            toolbar: [
                ['undo', ['undo']],
                ['redo', ['redo']],
                ['style', ['bold', 'italic', 'underline']],
                ['font', ['strikethrough']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ol', 'paragraph']],
                ['insert', ['picture', 'link']] // Add picture button for image upload
                // ['para', ['ul','ol', 'paragraph']],
            ],
            popover: {
                image: [
                    ['custom', ['examplePlugin']],
                    ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                    ['float', ['floatLeft', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']]
                ]
            }
        });
    });
</script>
    <script>
        function toggleSelectOptions() {
            var dealsRadio = document.getElementById('dealsRadio');
            var servicesRadio = document.getElementById('servicesRadio');
            var dealsSelect = document.getElementById('dealsSelect');
            var servicesSelect = document.getElementById('servicesSelect');

            // Toggle visibility based on selected radio button
            if (dealsRadio.checked) {
                dealsSelect.style.display = 'block';
                servicesSelect.style.display = 'none';
            } else if (servicesRadio.checked) {
                servicesSelect.style.display = 'block';
                dealsSelect.style.display = 'none';
            }
        }

        function seturl(data) {
            // Define the base URLs with placeholders for dynamic segments
            var unitBaseUrl = @json(route('unit-details', ['product_slug' => 'placeholder', 'unitslug' => 'placeholder']));
            var productDetailsBaseUrl = @json(route('productdetails', ['slug' => 'placeholder']));

            if (data === 'unit') {
                var deals = $('#deals').val(); // Get the value of the deals field
                if (deals) {
                    // Replace placeholders with actual values
                    var updatedUrl = unitBaseUrl.replace('placeholder', 'banners').replace('placeholder', deals);
                    $('#url').val(updatedUrl); // Set the updated URL in the input field
                } else {
                    alert('Please select a deal!');
                }
            }

            if (data === 'services') {
                var services = $('#services').val(); // Get the value of the services field
                if (services) {
                    // Replace placeholder with actual value
                    var updatedUrl = productDetailsBaseUrl.replace('placeholder', services);
                    $('#url').val(updatedUrl); // Set the updated URL in the input field
                } else {
                    alert('Please select a service!');
                }
            }
        }
    </script>
@endpush
