@extends('layouts.admin_layout')
@section('body')
<script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Dashboard
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
            <div class="card-body p-4">
                @if(isset($emailTemplate))
                <form method="post" enctype="multipart/form-data" action="{{url('/admin/email-template/'.$emailTemplate->id)}}" id="validation">
                @method('PUT')
                @else
                <form method="post" action="{{route('email-template.store')}}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="row">
                        
                        <div class="mb-3 col-lg-6">
                            <label for="title" class="form-label">Template Title</label>
                            <input class="form-control" type="text" name="title" placeholder="Title" id="title" value="{{isset($emailTemplate)?$emailTemplate->title:''}}">
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="subject" class="form-label">Subject</label>
                            <input class="form-control" type="text" name="subject" value="{{isset($emailTemplate)?$emailTemplate->subject:''}}" placeholder="subject" id="subject">
                        </div>
                       
                        <div class="mb-3 col-lg-12">
                         
                            <label for="summernote" class="form-label">Template Design </label>
                            <p class="text-danger">
                                Use Variable for getdata
                                <li> From Email=['from']</li>
                                <li> Message=['msg']</li>
                                <li> To Email=['to']</li>
                                <li> To Email=['to_name']</li>
                                <li>Amount=['amount']</li>
                                <li> From Name=['from_name']</li>
                                <li> Gift Card Code=['code']</li></br>
                             <p>
                            <textarea name="html_code"  id="content" rows="4" class="form-control">{{isset($emailTemplate)?$emailTemplate->html_code:''}}</textarea>
                            
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
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>
@endsection


@push('script')
    

<script>
    function couponRedeem() {
        // Get the selected radio button
        var selectedValue = document.querySelector('input[name="coupon"]:checked').value;

        // You can perform actions based on the selected value
        if (selectedValue === 'yes') {
            // Code to handle when "YES" is selected
            $('.coupon_code').show();
        } else if (selectedValue === 'no') {
            // Code to handle when "NO" is selected
            $('.coupon_code').hide();
        }
    }
</script>

{{-- <script src="{{ URL::asset('/assets/js/pages/form-editor.init.js') }}"></script>
 --}}

{{-- <script>
    ClassicEditor
            .create( document.querySelector( '#editor' )
            
            )
            .then( editor => {
                    console.log( editor );
            } )
            .catch( error => {
                    console.error( error );
            } );
</script> --}}
{{-- <script>
   <script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo', 'sourceEditing']
        })
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script> --}}
<script>
    $('#summernote').summernote({
      placeholder: 'Hello stand alone ui',
      tabsize: 2,
      height: 120,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ]
    });
  </script>


  
<script>
      function geftCardSendToOther(){
        var recipientRadios = document.getElementsByName('recipient');
    
        for (var i = 0; i < recipientRadios.length; i++) {
          // alert(recipientRadios[i].value);
        if (recipientRadios[i].value=='other' && recipientRadios[i].checked) {
          // Display the selected value
          $('.self').css({'display':'block'});
          break; // Exit the loop since we found the selected radio button
        }
        if (recipientRadios[i].value=='self' && recipientRadios[i].checked) {
          // Display the selected value
          $('.self').css({'display':'none'});
          break; // Exit the loop since we found the selected radio button
        } 
      }
      }
    
     
      </script>
    <script>
        CKEDITOR.replace( 'content', {
         height: 300,
         filebrowserUploadUrl: "{{url('/ckeditor')}}/script.php"
        });
       </script>
@endpush