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
                    <h3 class="mb-0">Service Order History</h3>
                   
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Orders</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Service Order History
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
            {{ $data->onEachSide(5)->links() }}
            <table id="datatable-buttons" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Order Number</th>
                    <th>View Order</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Transaction Id</th>
                    <th>Total Amount</th>
                    <th>Transaction Amount</th>
                    <th>Gift Card Use</th>
                    <th>Payment Status</th>
                    <th>Transaction Status</th>
                    <th>Created Date & Time</th>
                   
                </tr>
                </thead>


                <tbody>
                    @foreach($data as $key=>$value)
                    
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$value->order_id}}</td>
                    <td><a type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop_{{ $value['id'] }}"
                        onclick="OrderView({{ $key }},'{{ $value['order_id'] }}')">
                        View Card
                    </a></td>
                    <td>{{$value->fname ." ".$value->lname}}</td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->phone}}</td>
                    <td>{{$value->city}}</td>
                    <td>{{$value->country}}</td>
                    <td>{{$value->payment_intent}}</td>
                    <td>{{$value->final_amount}}</td>
                    <td>{{$value->transaction_amount}}</td>
                    <td>{{$value->gift_card_applyed}}</td>
                    <td><span class="badge text-bg-{{$value->payment_status =='paid'?'success':'danger'}}">{{ucFirst($value->payment_status)}}</span></td>
                    <td><span class="badge text-bg-{{$value->transaction_status =='complete'?'success':'danger'}}">{{ucFirst($value->transaction_status)}}</span></td>
                    <td>{{date('m-d-Y h:i:m',strtotime($value->updated_at))}}</td>
                
                </tr>
                @endforeach
                
                </tbody>
            </table>
            {{ $data->onEachSide(5)->links() }}
            <!--end::Row-->               
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>

 <!-- for Show Service Order Modal -->
 <div class="modal fade deepak" id="staticBackdrop_" data-bs-backdrop="static" data-bs-keyboard="false"
 tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
 <div class="modal-dialog">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="staticBackdropLabel">All Services </h5>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
function OrderView(id, order_id) {
    $('.deepak').attr('id', 'staticBackdrop_' + id);
    $('#staticBackdrop_' + id).modal('show');

    $.ajax({
    url: '{{ route('order-search') }}',
    method: "post",
    dataType: "json",
    data: {
        _token: '{{ csrf_token() }}',
        order_id: order_id,
        email: "",
        phone: "",
        user_token: '{{ Auth::user()->user_token }}',
    },
    success: function(response) {
        if (response.success) {
            // Clear previous table content
            $('#giftcardsshow').empty();

            // Create table structure
            var table = $('<table class="table table-bordered table-striped">');
            var thead = $('<thead>').html(
                '<tr>' +
                '<th>#</th>' +
                '<th>Product Name</th>' +
                '<th>Total Session</th>' +
                '</tr>'
            );
            var tbody = $('<tbody>');

            // Append header to the table
            table.append(thead);

            // Loop through the response result array
            $.each(response.result, function(index, element) {
                // Create a new row for each element
                var row = $('<tr>').html(
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + element.product_name + '</td>' +
                    '<td>' + element.number_of_session + '</td>'
                );
                // Append the row to the tbody
                tbody.append(row);
            });

            // Append tbody to the table
            table.append(tbody);

            // Append the table to #giftcardsshow
            $('#giftcardsshow').append(table);
        } else {
            // Handle the case when the response is not successful
            $('#giftcardsshow').html('<p>No services found.</p>');
        }
    },
    error: function(xhr, status, error) {
        // Handle error response
        $('#giftcardsshow').html('<p>An error occurred. Please try again later.</p>');
    }
});


}
</script>
@endpush

