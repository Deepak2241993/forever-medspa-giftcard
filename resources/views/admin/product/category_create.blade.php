@extends('layouts.admin_layout')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h3 class="mb-0">Service Deals Create</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Service Deals Add/Update
                        </li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content-header">
   
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <span class="text-danger">
            @if(session()->has('error'))
                {{ session()->get('error') }}
            @endif
        </span>
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="card-body p-4">
                @if(isset($data))
                    <form method="post"
                        action="{{ route('category.update', $data['id']) }}"
                        enctype="multipart/form-data">
                        @method('PUT')
                    @else
                        <form method="post" action="{{ route('category.store') }}"
                            enctype="multipart/form-data">
                @endif
                @csrf
                <div class="row">
                    <div class="mb-3 col-lg-6 self">
                        <label for="title" class="form-label">Deal Name</label>
                        <input class="form-control" id="title" type="text" name="cat_name"
                            value="{{ isset($data) ? $data['cat_name'] : '' }}"
                            placeholder="Category Name" onkeyup="slugCreate()">
                    </div>
                    <div class="mb-3 col-lg-6 self">
                        <label for="slug" class="form-label">Deal Slug</label>
                        <input class="form-control" id="slug" type="text" name="slug"
                            value="{{ isset($data) ? $data['slug'] : '' }}"
                            placeholder="Category slug">
                    </div>
                    <div class="mb-3 col-lg-6 self">
                        <label for="deal_start_date" class="form-label">Deal Start Date</label>
                        <input class="form-control" id="deal_start_date" type="date" name="deal_start_date"
                            value="{{ isset($data) ? $data['deal_start_date'] : '' }}">
                    </div>
                    <div class="mb-3 col-lg-6 self">
                        <label for="deal_end_date" class="form-label">Deal End Date</label>
                        <input class="form-control" id="deal_end_date" type="date" name="deal_end_date"
                            value="{{ isset($data) ? $data['deal_end_date'] : '' }}">
                    </div>

                    <div class="mb-12 col-lg-12 self">
                        <label for="cat_description" class="form-label">Deal Description</label>
                        <textarea name="cat_description" id="cat_description" rows="4"
                            class="form-control">{{ isset($data) ? $data['cat_description'] : '' }}</textarea>
                    </div>
                    @if(isset($data))
                        <div class="mb-3 col-lg-6 mt-4 self">
                            <label for="image" class="form-label">Deal Image</label>
                            @isset($data['cat_image'])
                                <div id="image_class">
                                    <img src="{{ $data['cat_image'] }}"
                                        style="width:80%; height:100px;" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';"><span>
                                        <buttom class="btn btn-danger" onclick="hideImage()">X</buttom>
                                    </span>
                                </div>
                            @endisset
                            <div id="image_field" <blade
                                if|%20(%24data%5B%26%2339%3Bcat_image%26%2339%3B%5D%20!%3D%20%26%2339%3B%26%2339%3B)%20style%3D%26%2334%3Bdisplay%3A%7B%7Bisset(%2524data%255B%2526%252339%253Bid%2526%252339%253B%255D)%2520%253F%2520%2526%252339%253Bnone%2526%252339%253B%2520%253A%2520%2526%252339%253Bblock%2526%252339%253B%7D%7D%26%2334%3B%20%40endif%3E>
                                <input class="form-control" id="image" type="file" name="cat_image">
                            </div>
                        </div>
                    @else
                        <div class="mb-3 col-lg-6 mt-4">
                            <label for="from" class="form-label">Deal Image</label>
                            <input class="form-control" id="image" type="file" name="cat_image">
                            <input class="form-control" id="image" type="hidden" name="status" value="1">
                        </div>
                    @endif

                    {{-- <div class="mb-3 col-lg-6 mt-4">
                            <label for="from" class="form-label">Status</label>
                            <select class="form-control" name="status" id="from">
                                <option value="1"{{ isset($data['status']) && $data['status'] == 1 ? 'selected' : '' }}
                    >Active</option>
                    <option value="0"
                        {{ isset($data['status']) && $data['status'] == 0 ? 'selected' : '' }}>
                        Inactive</option>
                    </select>
                </div> --}}

                <div class="mb-3 col-lg-12">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
            </form>
        </div>
        <!--end::Row-->
        <!-- /.Start col -->
    </div>
    <!-- /.row (main row) -->
</section>
@endsection
@push('script')
    <script>
        CKEDITOR.replace('cat_description', {
            height: 300,
            filebrowserUploadUrl: "{{ url('/ckeditor') }}/script.php"
        });

    </script>
    <script>
        function hideImage() {
            $('#image_class').hide();
            $('#image_field').show();
        }

    </script>
    <script>
        function slugCreate() {
            $.ajax({
                url: '{{ route('slugCreate') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_name: $('#title').val(),
                },
                success: function (response) {
                    if (response.success) {
                        $('#slug').val(response.slug);
                    } else {
                        $('.showbalance').html(response.error).show();
                    }
                }
            });
        }

    </script>
    <script>
        // Get the current date
        var today = new Date().toISOString().split('T')[0];
        // Set the min attribute of the date input field to today
        document.getElementById('deal_start_date').setAttribute('min', today);

    </script>
    <script>
        // Get the current date
        var today = new Date().toISOString().split('T')[0];
        // Set the min attribute of the date input field to today
        document.getElementById('deal_end_date').setAttribute('min', today);

    </script>
@endpush
