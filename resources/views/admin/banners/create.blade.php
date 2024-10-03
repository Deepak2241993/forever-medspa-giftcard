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
              <li class="breadcrumb-item"><a href="{{url('/root')}}">Home</a></li>
              <li class="breadcrumb-item active">All Create/Update</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
</section>
    <section class="content-header">
        <!--begin::App Content Header-->
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
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
                    @if (isset($banner))
                    <form method="post" action="{{ route('banner.update', $banner->id) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                        @else
                    <form method="post" action="{{ route('banner.store') }}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-lg-6 self">
                            <label for="title" class="form-label">Slider Title<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="title" value="{{ isset($banner) ? $banner->title : '' }}" placeholder="Title" required>
                        </div>
                       

                       
                        <div class="mb-3 col-lg-6 self">
                            <label for="amount" class="form-label">URL<span class="text-danger">*</span></label>
                            <input class="form-control" id="amount" type="url" min="1" name="url"
                                value="{{ isset($banner) ? $banner->url : '' }}" placeholder="Url" required>
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="image" class="form-label">Slider Image<span class="text-danger">* Width 1349 Height 550</span></label>
                            <input class="form-control" id="image" type="file" name="image" required>
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="from" class="form-label">Status</label>
                            <select class="form-control" name="status" id="from">
                                <option
                                    value="1"{{ isset($banner->status) && $banner->status == 1 ? 'selected' : '' }}>
                                    Active</option>
                                <option
                                    value="0"{{ isset($banner->status) && $banner->status == 0 ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                        </div>
                        

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
