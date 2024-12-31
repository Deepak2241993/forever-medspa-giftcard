@extends('layouts.patient_layout')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h3 class="mb-0">Giftcard Redeem History</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('admin-dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Giftcard Redeem History
                        </li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content-header">
    
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            @if($result->count())
            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Gift Card Holder Name</th>
                        <th>Gift Card Holder Email </th>
                        <th>Gift Card Number</th>
                        <th>Gift Card Amount</th>
                        <th>Gift Card Status</th>
                        {{-- <th>Created Time</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result as $key=>$value)
                    @if($value->gift_send_to == Auth::guard('patient')->user()->email)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->recipient_name ? $value->recipient_name:$value->your_name }}</td>
                        <td>{{ $value->gift_send_to }}</td>
                        <td>{{ $value->giftnumber }}</td>
                        <td>{{ '$'.$value->total_amount }}</td>
                        <td>{!! $value->status!=0?'<span class="badge text-bg-success">Active</span>':'<span class="badge text-bg-danger">Inactive</span>' !!}</td>
                        <td>
                        <a type="button"  class="btn btn-block btn-outline-primary" data-bs-toggle="modal" data-bs-target="#Statment_{{$value->user_id}}" onclick="Statment({{$value->user_id}},'{{$value->giftnumber}}')">
                            View Statement</a>
                        
                        </td>
                        <!-- Button trigger modal -->
                    </tr>
                   @endif
                    @endforeach
                </tbody>
               
            </table>
           
            @else
            <hr>
            <p> No Data found </p>
            @endif
            <!--end::Row-->               
                <!-- /.Start col -->
        </div>
</section>

  {{--  For Statment Mpdal --}}
    <div class="modal fade Statment" id="Statment_" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Gift Card History</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
                </div>
                <div class="modal-body">
                    <table class="statment_view table table-striped"></table>
                    <b><span class="text-danger">*</span>Any Transaction Number starting with the prefix "CANCEL", denotes the particular Giftcard has been cancelled and is inactive henceforth</b>
                </div>
                <div class="modal-footer">
                   <button type="button"  class="btn btn-block btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
  @endsection

  @push('script')
      
<script>
    function Statment(id,giftcardnumber){
    $('.Statment').attr('id', 'Statment_' + id);

    $.ajax({
        url: '{{ route('giftcardstatment') }}',
        method: "post",
        dataType: "json",
        data: {
            _token: '{{ csrf_token() }}',
            gift_card_number: giftcardnumber,
            user_token: '{{Auth::guard('patient')->user()->user_token}}',
        },
        success: function(response) {
    console.log(response);
    if(response.status == 200) {
        $('#Statment_' + id).modal('show');

        // Clear the content of the statment_view element
        $('.statment_view').empty();

        // Create the table header
        var tableHeader = `
            <tr>
                <th>Sl No.</th>
                <th>Transaction Number</th>
                <th>Card Number</th>
                <th>Date</th>
                <th>Message</th>
                <th>Value Amount</th>
                <th>Actual Paid Amount</th>
            </tr>
        `;
        // Append the table header to statment_view
        $('.statment_view').append(tableHeader);

        // Iterate over each element in the response.result array
        $.each(response.result, function(index, element) {
    // Parse the date string into a JavaScript Date object
    var date = new Date(element.updated_at);
    
    // Format the date components
    var formattedDate = (date.getMonth() + 1) + '-' + date.getDate() + '-' + date.getFullYear();

    // Create a new row for each element
    var newRow = `
        <tr>
            <td>${index + 1}</td>
            <td>${element.transaction_id}</td>
            <td>${element.giftnumber}</td>
            <td>${formattedDate}</td>
            <td>${element.comments ? element.comments : 'Self'}</td>
            <td>$${element.amount}</td>
            <td>$${element.actual_paid_amount}</td>
        </tr>
    `;

    // Append the new row to the element with class "statment_view"
    $('.statment_view').append(newRow);
});

        var totalamount = `
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><b><u>Available Amount</u></b></td>
            <td><b><u>Refund</u></b></td>
        </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>$${response.TotalAmount}</b></td>
                    <td><b>$${response.actual_paid_amount}</b></td>
                </tr>
            `;
            $('.statment_view').append(totalamount);
    } else {
        $('#Statment_' + id).modal('show');
        $('.statment_view').html(response.error);
    }
}

    });
    }


    </script>
    
  @endpush
