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
                            <label for="product_name" class="form-label">Service Name<span class="text-danger">*</span></label>
                            <input class="form-control" id="product_name" required type="text" name="product_name" value="{{isset($data)?$data['product_name']:''}}" placeholder="Product Name" onkeyup="slugCreate()">
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="product_slug" class="form-label">Service Slug<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="product_slug" value="{{isset($data)?$data['product_slug']:''}}" placeholder="Slug" id="product_slug">
                        </div>
                        <div class="mb-3 col-lg-12 self">
                            <label class="form-label">Select Service Category <span class="text-danger">*</span></label>
                            @if($category)
                                {{-- @foreach($category as $value)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="cat_id[]" value="{{ $value['id'] }}" 
                                            {{ isset($data['cat_id']) && (is_array($data['cat_id']) ? in_array($value['id'], $data['cat_id']) : $data['cat_id'] == $value['id']) ? 'checked' : '' }} >
                                        <label class="form-check-label" for="cat_{{ $value['id'] }}" >
                                            {{ $value['cat_name'] }}
                                        </label>
                                    </div>
                                @endforeach --}}
                                @foreach($category as $value)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="cat_id[]" value="{{ $value['id'] }}" 
                                        {{ isset($data['cat_id']) && (is_array($data['cat_id']) ? in_array($value['id'], $data['cat_id']) : $data['cat_id'] == $value['id']) ? 'checked' : '' }} >
                                    <label class="form-check-label" for="cat_{{ $value['id'] }}">
                                        {{ $value['cat_name'] }}
                                    </label>
                                </div>
                            @endforeach
                            @else
                                <div>No Category Found</div>
                            @endif
                        </div>
                        
                        
                       
                        <div class="mb-12 col-lg-12 self">
                            <label for="short_description" class="form-label">Short Description
                                <span class="text-danger"> (Text Limit 50 Word)</span>
                            </label>
                            <textarea name="short_description" id="short_description" class="form-control" required>{{ isset($data) ? $data['short_description'] : '' }}</textarea>
                            <span id="count" class="text-danger"></span>
                        </div>
                        <div class="mb-12 col-lg-12 self mt-3">
                            <label for="product_description" class="form-label">Service Description</label>
                            <textarea name="product_description"  id="product_description" class="form-control summernote" onkeyup="calculate()">{{isset($data)?$data['product_description']:''}}</textarea>
                        </div>
                        <div class="mb-12 col-lg-12 self mt-3">
                            <label for="prerequisites" class="form-label">Prerequisites</label>
                            <textarea name="prerequisites"  id="prerequisites" class="form-control summernote">{{isset($data)?$data['prerequisites']:''}}</textarea>
                        </div>




                        @php
                        if(isset($data))
                        {
                        $image = explode('|',$data['product_image']);
                        }
                        @endphp
                        @if(isset( $image))
                    <div class="box" style="border:solid 1px;" id="image_class">
                                            <button type="button" style="
                        background-color: red;
                        color: #ffffff;
                        border: red;
                        width: 30px;
                        height: 25px;
                        justify-content: flex-start;
                        align-items: center;

                    " onclick="hideImage({{1}})">X</button>  
                        <div class="row">

                        @foreach($image as $key=>$imagevalue)
                            @isset($imagevalue)
                        
                           
                                <div class="mb-3 col-lg-4 self">
                                    <label for="product_image" class="form-label">Service Image</label><br>
                                            <img src="{{$imagevalue }}" class="mb-4" style="width:80%; height:100px; margin-right: -20px;">
                                            
                                </div>  
                           
                
                            @endisset
                        @endforeach
                    </div>
                    
                </div>
                @endif
                   
                        <div class="mb-3 col-lg-6 self" id="image_field" style="display:{{isset($data['id'])?'none':'block'}}">
                            <label for="product_image" class="form-label">Service Image<span class="text-danger">*</span></label><br>                                
                                <input class="form-control" id="image" type="file" name="product_image[]" multiple {{isset($data)?'':'required'}}>
                        </div> 
                      
                        <div class="mb-3 col-lg-6 self">
                            <label for="amount" class="form-label">Service Original Price<span class="text-danger">*</span> </label>
                            <input class="form-control" type="number" min="0" name="amount" value="{{isset($data)?$data['amount']:''}}" placeholder="Service Original Price" required>
                            <input class="form-control" type="hidden" min="0" name="id" value="{{isset($data)?$data['id']:''}}">
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="discounted_amount" class="form-label">Service Price<span class="text-danger">*</span></label>
                            <input class="form-control" type="number" min="0" name="discounted_amount" value="{{isset($data)?$data['discounted_amount']:''}}" placeholder="Service Price" required>
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="session_number" class="form-label">Number of session<span class="text-danger">*</span></label>
                            <input class="form-control" type="number" min="1" name="session_number" value="{{isset($data)?$data['session_number']:'1'}}" placeholder="Number Of Session" required>
                        </div>
                     
                        <div class="mb-12 col-lg-12 self">
                            <label for="search_keywords" class="form-label">Search Keywords</label>
                            <textarea name="search_keywords"  id="search_keywords" rows="4" class="form-control">{{isset($data)?$data['search_keywords']:''}}</textarea>
                            <input class="form-control" id="image" type="hidden" name="status" value="1">
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
                            <label for="from" class="form-label">Popular Services</label>
                            <select class="form-control" name="popular_service" id="from">
                                <option value="1"{{ isset($data['popular_service']) && $data['popular_service'] == 1 ? 'selected' : '' }} >Yes</option>
                                <option value="0"{{ isset($data['popular_service']) && $data['popular_service'] == 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label for="giftcard_redemption" class="form-label">Giftcard Redeem</label>
                            <select class="form-control" name="giftcard_redemption" id="from">
                                <option value="1"{{ isset($data['giftcard_redemption']) && $data['giftcard_redemption'] == 1 ? 'selected' : '' }} >Yes</option>
                                <option value="0"{{ isset($data['giftcard_redemption']) && $data['giftcard_redemption'] == 0 ? 'selected' : '' }}selected>No</option>
                            </select>
                        </div>
                        <div class="mb-3 col-lg-6 mt-4">
                            <button class="btn btn-primary" type="submit" id="submitBtn">Submit</button>
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
    <script>
        function slugCreate(){
        $.ajax({
          url: '{{ route('slugCreate') }}',
          method: "post",
          dataType: "json",
          data: {
              _token: '{{ csrf_token() }}',
              product_name: $('#product_name').val(),
          },
          success: function (response) {
              if (response.success) {
                $('#product_slug').val(response.slug);				
              } 
   		else{
   			$('.showbalance').html(response.error).show();
   		}
          }
      });
        }
    </script>
  <script>
    var calculate = function() {
        var string = document.getElementById('short_description').value;
        var words = string.trim().split(/\s+/).filter(word => word.length > 0);
        var wordCount = words.length;
        
        if (wordCount > 50) {
            document.getElementById('short_description').value = words.slice(0, 50).join(' ');
            wordCount = 50;
        }

        document.getElementById('count').innerHTML = wordCount + " / 50 words";
    };

    // Add event listener to count words when the content changes
    document.getElementById('short_description').addEventListener('input', calculate);
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('input[name="cat_id[]"]');
        const submitBtn = document.getElementById('submitBtn');

        function toggleSubmitButton() {
            const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            submitBtn.disabled = !anyChecked;
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', toggleSubmitButton);
        });

        // Initial check on page load
        toggleSubmitButton();
    });
</script>
@endpush