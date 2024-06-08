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
                    <h3 class="mb-0">Resend Mail</h3>
                    @if(session()->has('error'))
                    <h3 class="text-danger">  {{ session()->get('error') }}</h3>
                    <a href="{{route('cardgenerated-list')}}" class="btn btn-warning">Go Back</a>
                  @endif
                  @if(session()->has('message'))
                  <h3 class="text-success"> {{ session()->get('message') }}</h3>
                  <a href="{{route('cardgenerated-list')}}" class="btn btn-warning">Go Back</a>
                  @endif
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
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
    <form method="post" action="{{route('resendmail')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="mb-3 col-lg-6">
                <label for="title" class="form-label">Name</label>
                <input class="form-control" type="text" name="recipient_name" value="{{isset($mail_data) && $mail_data->recipient_name?$mail_data->recipient_name:$mail_data->your_name}}" placeholder="To">
            </div>
            <div class="mb-3 col-lg-6">
                <label for="title" class="form-label">To</label>
                <input class="form-control" type="text" name="gift_send_to" value="{{isset($mail_data)?$mail_data->gift_send_to:''}}" placeholder="To">
            </div>
            <div class="mb-3 col-lg-6">
                <label for="title" class="form-label">CC</label>
                <input class="form-control" type="text" name="cc" value="{{isset($mail_data)?$mail_data->title:''}}" placeholder="Cc">
            </div>
            <div class="mb-3 col-lg-6">
                <label for="title" class="form-label">Bcc</label>
                <input class="form-control" type="text" name="bcc" value="{{isset($mail_data)?$mail_data->title:''}}" placeholder="Bcc">
            </div>
            
            
            <div class="mb-3 col-lg-12">
                <label for="amount" class="form-label">Message</label>
               <textarea name="message" id="summernote" cols="30" rows="10">@include('email.resedgiftcard')
            </textarea>
              
            </div>
            <div class="mb-3 col-lg-10">
            <BUTTON class="btn btn-primary">Send</BUTTON>
           
            </div>
        </div>
    </form>
            </div>
        </div>
    </div>
</main>

@endsection

@push('script')
<script>
    $('#summernote').summernote({
      placeholder: 'Hello stand alone ui',
      tabsize: 2,
      height: 420,
    //   toolbar: [
    //     ['style', ['style']],
    //     ['font', ['bold', 'underline', 'clear']],
    //     ['color', ['color']],
    //     ['para', ['ul', 'ol', 'paragraph']],
    //     ['table', ['table']],
    //     ['insert', ['link', 'picture', 'video']],
    //     ['view', ['fullscreen', 'codeview', 'help']]
    //   ]
    });
  </script>
@endpush