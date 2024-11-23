@extends('layouts.admin_layout')
@section('body')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>All Create/Update</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/root') }}">Home</a></li>
                    <li class="breadcrumb-item active">All Create/Update</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content-header">
    <!--begin::App Content Header-->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="card-body p-4">
    @if(isset($banner))
        <form method="post" action="{{ route('banner.update', $banner->id) }}" enctype="multipart/form-data">
        @method('PUT')
    @else
        <form method="post" action="{{ route('banner.store') }}" enctype="multipart/form-data">
    @endif
    @csrf
    <div class="row">
        <!-- Title -->
        <div class="mb-3 col-lg-6">
            <label for="title" class="form-label">Slider Title<span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="title" value="{{ isset($banner) ? $banner->title : '' }}" placeholder="Title" required>
        </div>

        <!-- URL -->
        <div class="mb-3 col-lg-6">
            <label for="url" class="form-label">URL<span class="text-danger">*</span></label>
            <input class="form-control" id="url" readonly type="url" name="url" value="{{ isset($banner) ? $banner->url : '' }}" placeholder="Url" required>
        </div>

        <!-- Slider Image -->
        <div class="mb-3 col-lg-6">
            <label for="image" class="form-label">Slider Image<span class="text-danger">* Width 1349 Height 550</span></label>
            <input class="form-control" id="image" type="file" name="image" required>
        </div>

        <!-- Status -->
        <div class="mb-3 col-lg-6">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" name="status" id="status">
                <option value="1" {{ isset($banner->status) && $banner->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ isset($banner->status) && $banner->status == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <!-- Radio Buttons for Deals/Services -->
        <div class="mb-3 col-lg-6">
            <label class="form-label">Select Type</label><br>
            <input type="radio" name="type" value="1" id="dealsRadio" onclick="toggleSelectOptions()" required> Unit
            <input type="radio" name="type" value="2" id="servicesRadio" onclick="toggleSelectOptions()" required> Service
        </div>

        <!-- Deals Select Option (Initially Hidden) -->
        <div class="mb-3 col-lg-6" id="dealsSelect" style="display: none;">
            <label for="deals" class="form-label">Select Unit</label>
            <select class="form-control" name="deals_and_service" id="deals" onchange="seturl('unit')">
                <option value="">Select Unit</option>
                @foreach($unit as $value)
                <option value="{{$value->product_slug}}">{{$value->product_name}}</option>
                @endforeach
                <!-- Add more deals as needed -->
            </select>
        </div>

        <!-- Services Select Option (Initially Hidden) -->
        <div class="mb-3 col-lg-6" id="servicesSelect" style="display: none;">
            <label for="services" class="form-label">Select Services</label>
            <select class="form-control" name="deals_and_service" id="services" onchange="seturl('services')">
            <option value="">Select Service</option>
            @foreach($services as $value)
                <option value="{{$value->product_slug}}">{{$value->product_name}}</option>
                @endforeach
                <!-- Add more services as needed -->
            </select>
        </div>

        <!-- Submit Button -->
        <div class="mb-3 col-lg-6">
            <button class="btn btn-primary" type="submit" name="submit">Submit</button>
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
        // Define the base URLs (without the slug)  
        var productBaseUrl = @json(route('services', ''));
        var productDetailsBaseUrl = @json(route('productdetails', ''));

        if (data === 'unit') {
            var deals = $('#deals').val();  // Get the value of the deals field
            var updatedUrl = productBaseUrl + '/' + deals;  // Append the deal slug
            $('#url').val(updatedUrl);  // Set the updated URL in the input field
        }

        if (data === 'services') {
            var services = $('#services').val();  // Get the value of the services field
            var updatedUrl = productDetailsBaseUrl + '/' + services;  // Append the service slug
            $('#url').val(updatedUrl);  // Set the updated URL in the input field
        }
    }
</script>

@endpush
