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
                    <h3 class="mb-0">Product Category</h3>
                   
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Category
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
            <a href="{{route('category.create')}}" class="btn btn-primary">Add More</a>
            <div class="card-header text-success">
                @if(session()->has('success'))
                    {{ session()->get('success') }}
                @endif
            </div>
            @if($data['status']==200)
            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Categories Name</th>
                    <th>Categories Image</th>
                    <th>Categories Description</th>
                    <th>Categories At</th>
                    <th>Action</th>
                   
                   </tr>
                </thead>
                 <tbody>
                    @foreach($data['result'] as $key => $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value['cat_name'] ? $value['cat_name']:'NULL' }}</td>
                       <td>
    @if(isset($value['cat_image']))
        <img src="{{ $value['cat_image'] }}" style="height:100px; width:100px;">
    @endif
</td>
                        <td>{!! mb_strimwidth(isset($value['cat_description']) ? $value['cat_description'] : 'NULL', 0, 200, '...') !!}</td>
                        <td>{{ date('m-d-Y h:i:s',strtotime($value['created_at'])) }}</td>
                        <td>
                            <a href="{{route('category.edit', $value['id'])}}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('category.destroy', $value['id']) }}" method="POST">
                                @method('DELETE')
                                @csrf <!-- Include CSRF token for security -->
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                       
                        
                        <!-- Button trigger modal -->
                    </tr>
                @endforeach
                </tbody>
            </table>
            @else
            {{($data['error'])}}
            @endif
            <!--end::Row-->               
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>


  <!-- Modal -->
  <div class="modal fade deepak" id="staticBackdrop_" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Gift Card Number</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <h2 id="giftcardsshow"></h2>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  @endsection

  @push('script')
      
<script>

function cardview(id,tid) {
    $('.deepak').attr('id', 'staticBackdrop_' + id);
    $('#staticBackdrop_' + id).modal('show');

    $.ajax({
        url: '{{ route('cardview-route') }}',
        method: "post",
        dataType: "json",
        data: {
            _token: '{{ csrf_token() }}',
            tid: tid,
            user_token: '{{Auth::user()->user_token }}',
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
    
  @endpush
