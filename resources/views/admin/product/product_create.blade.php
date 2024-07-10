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
                    <h3 class="mb-0">Service Create</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                           Service Add/Update
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
       <span class="text-danger"> @if(session()->has('error'))
        {{ session()->get('error') }}
    @endif</span>
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="card-body p-4">
                @if(isset($data))
                
                <form method="post" action="{{route('product.update',$data['id'])}}" enctype="multipart/form-data">
                    @method('PUT')
                @else
                    <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-lg-6 self">
                            <label for="product_name" class="form-label">Service Name</label>
                            <input class="form-control" type="text" name="product_name" value="{{isset($data)?$data['product_name']:''}}" placeholder="Product Name">
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="cat_id" class="form-label">Service Category</label>
                            <select name="cat_id" class="form-control">
                                <option value="">Select Category</option>
                                @if($category)
                                    @foreach($category as $value)
                                        <option value="{{$value['id']}}" {{ isset($data['id']) && $data['cat_id'] == $value['id'] ? 'selected' : '' }}>{{$value['cat_name']}}</option>
                                    @endforeach
                                @else
                                    <option>No Category Found</option>
                                @endif
                            </select>
                            
                        </div>
                       
                        <div class="mb-12 col-lg-12 self">
                            <label for="product_description" class="form-label">Service Description</label>
                            <textarea name="product_description"  id="product_description" class="form-control summernote">{{isset($data)?$data['product_description']:''}}</textarea>
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="product_image" class="form-label">Service Image</label><br>
                            @isset($data['product_image'])
                                <div id="image_class">
                                    <img src="{{ $data['product_image'] }}" class="mb-4" style="width:80%; height:100px;"><span> <buttom class="btn btn-danger" onclick="hideImage()">X</buttom></span>
                                </div>
                            @endisset
                            <div id="image_field" style="display:{{isset($data['id'])?'none':'block'}}">
                                <input class="form-control" id="image" type="file" name="product_image">
                            </div>
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="discounted_amount" class="form-label">Service Discounted Price</label>
                            <input class="form-control" type="number" min="0" name="discounted_amount" value="{{isset($data)?$data['discounted_amount']:''}}" placeholder="Product Name">
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="amount" class="form-label">Service Amount MRP</label>
                            <input class="form-control" type="number" min="0" name="amount" value="{{isset($data)?$data['amount']:''}}" placeholder="Product Name">
                            <input class="form-control" type="hidden" min="0" name="id" value="{{isset($data)?$data['id']:''}}">
                        </div>
                        <div class="mb-12 col-lg-12 self">
                            <label for="search_keywords" class="form-label">Search Keywords</label>
                            <textarea name="search_keywords"  id="search_keywords" rows="4" class="form-control">{{isset($data)?$data['search_keywords']:''}}</textarea>
                        </div>
                        {{-- <div class="mb-12 col-lg-12 self">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <textarea name="meta_title"  id="meta_title" rows="4" class="form-control">{{isset($data)?$data['meta_title']:''}}</textarea>
                        </div>
                        <div class="mb-12 col-lg-12 self">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea name="meta_description"  id="meta_description" rows="4" class="form-control">{{isset($data)?$data['meta_description']:''}}</textarea>
                                          </div>
                        <div class="mb-12 col-lg-12 self">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <textarea name="meta_keywords"  id="meta_keywords" rows="4" class="form-control">{{isset($data)?$data['meta_keywords']:''}}</textarea>
                        </div> --}}
                       
                        <div class="mb-3 col-lg-6">
                            <label for="from" class="form-label">Status</label>
                            <select class="form-control" name="status" id="from">
                                <option value="1"{{ isset($data['status']) && $data['status'] == 1 ? 'selected' : '' }} >Active</option>
                                <option value="0"{{ isset($data['status']) && $data['status'] == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3 col-lg-6 mt-4">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
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

@push('script')

<script>
function hideImage(){
$('#image_class').hide();
$('#image_field').show();
}
</script>
{{--     
<script>
    CKEDITOR.replace( 'product_description', {
     height: 300,
     filebrowserUploadUrl: "{{url('/ckeditor')}}/script.php"
    });
</script> --}}
<script>

    $(document).ready(function() {
      $('.summernote').summernote({
        popover: {
          image: [
    
            // This is a Custom Button in a new Toolbar Area
            ['custom', ['examplePlugin']],
            ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
            ['float', ['floatLeft', 'floatRight', 'floatNone']],
            ['remove', ['removeMedia']]
          ]
        }
      });
    });
    </script>
@endpush