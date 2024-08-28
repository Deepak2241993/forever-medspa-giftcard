@extends('layouts.admin_layout')
@section('body')
@push('css')

    .spinner-border {
    display: inline-block;
    width: 1rem;
    height: 1rem;
    vertical-align: text-bottom;
    border: 0.1em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    animation: spinner-border 0.75s linear infinite;
}

@keyframes spinner-border {
    100% {
        transform: rotate(360deg);
    }
}


    @endpush()
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Service Redeem</h3>
                   
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Orders</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Service Redeem
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
        <form method="get" action="{{ route('search-service-order') }}">
            @csrf
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="order_id">Order Number:</label>
                    <input type="text" class="form-control" id="order_id" name="order_id" placeholder="Order Number">
                </div>
                <div class="col-md-4">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                </div>
                <div class="col-md-3">
                    <label for="phone">Phone Number:</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number">
                </div>
                <div class="col-md-1">
                    <input type="hidden" name="user_token" value="{{ Auth::user()->user_token }}">
                    <button type="submit" class="btn btn-success mt-4">Search</button>
                </div>
            </div>
        </form>
        
        <div class="container-fluid">
            <!--begin::Row-->
            {{ $data->onEachSide(5)->links() }}
            <table id="datatable-buttons" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>View Order</th>
                    <th>Order Number</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Transaction Amount</th>
                    <th>Transaction Id</th>
                    <th>Created Date & Time</th>
                   
                </tr>
                </thead>


                <tbody>
                    @foreach($data as $key=>$value)
                    
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td><a type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop_{{ $value['id'] }}"
                        onclick="OrderView({{ $key }},'{{ $value['order_id'] }}')">
                        View Card
                    </a></td>
                    <td>{{$value->order_id}}</td>
                    <td>{{$value->fname ." ".$value->lname}}</td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->phone}}</td>
                    <td>{{$value->payment_intent}}</td>
                    <td>{{$value->final_amount}}</td>
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
 <div class="modal-dialog modal-xl">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="staticBackdropLabel">All Services </h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
        <div class="modal-body">
                <div style="display: flex; flex-direction: column;">
                    {{-- <h5 id="client_name"></h5>
                    <h5 id="client_email"></h5>
                    <h5 id="client_phone"></h5> --}}
                    {{-- <h5 id="client_Order_number"></h5> --}}
                    <h3> Order Details</h3>
                    <span class="text-danger" id="error"></span>
                    <span class="text-success" id="success"></span>
                    <h2 id="giftcardsshow" class="mt-4"></h2>
                   
                </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
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

                // Create form and table structure
                var form = $('<form>', { action: '{{ route("redeem-services") }}', method: 'POST' });
                var table = $('<table class="table table-bordered table-striped">');
                var thead = $('<thead>').html(
                    '<tr>' +
                    '<th>#</th>' +
                    '<th>Product Name</th>' +
                    '<th>Total Session</th>' +
                    '<th>Remaining Session</th>' +
                    '<th>How Much Use</th>' +
                    '<th>Message</th>' +
                    '<th>Action</th>' +
                    '</tr>'
                );
                var tbody = $('<tbody>');

                // Append header to the table
                table.append(thead);

                // Loop through the response result array
                $.each(response.result, function(index, element) {
                    // Determine if the row should be disabled
                    var isDisabled = element.remaining_sessions === 0 ? 'disabled' : '';
                    var rowClass = element.remaining_sessions === 0 ? 'class="disabled-row"' : '';

                    // Create a new row for each element
                    var row = $('<tr ' + rowClass + '>').html(
                        `<td>${index + 1}</td>
                        <td>${element.product_name}</td>
                        <td>${element.number_of_session}</td>
                        <td id="row_${index + 1}">${element.remaining_sessions}</td>
                        <td>
                            <input type="hidden" name="service_id" value="${element.service_id}">
                            <input type="hidden" name="order_id" value="${element.order_id}">
                            <input onkeyup="valueValidate(this, ${element.remaining_sessions})" 
                                   onchange="valueValidate(this, ${element.remaining_sessions})" 
                                   type="number" 
                                   max="${element.remaining_sessions}" 
                                   min="0" 
                                   name="number_of_session_use" 
                                   value="${element.remaining_sessions}" 
                                   class="form-control" 
                                   ${isDisabled}>
                        </td>
                        <td>
                            <textarea class="form-control" name="comments" ${isDisabled}></textarea>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary mt-2 submit-btn" ${isDisabled}>
                                <span class="spinner-border spinner-border-sm" style="display: none;"></span>
                                Redeem
                            </button>
                        </td>`
                    );

                    // Append the row to the tbody
                    tbody.append(row);
                });

                // Append tbody to the table
                table.append(tbody);

                // Append table to form
                form.append(table);

                // Append form to #giftcardsshow
                $('#giftcardsshow').append(form);

                // Add event listener for submit button clicks
                $('.submit-btn').click(function() {
                    var button = $(this);
                    var spinner = button.find('.spinner-border');

                    // Show the spinner
                    spinner.show();
                    button.prop('disabled', true);

                    var currentRow = button.closest('tr');
                    var number_of_session_use = currentRow.find('input[name="number_of_session_use"]').val();
                    var remaining_sessions = currentRow.find('td:nth-child(4)').text(); // get remaining sessions value from table cell

                    // Validate that the number of sessions to use does not exceed remaining sessions
                    if (parseInt(number_of_session_use) > parseInt(remaining_sessions)) {
                        alert('You cannot redeem more sessions than the remaining sessions.');
                        spinner.hide();
                        button.prop('disabled', false);
                        return; // Stop the form submission
                    }

                    var rowData = {
                        _token: '{{ csrf_token() }}', // Add CSRF token
                        service_id: currentRow.find('input[name="service_id"]').val(),
                        order_id: currentRow.find('input[name="order_id"]').val(),
                        number_of_session_use: number_of_session_use,
                        comments: currentRow.find('textarea[name="comments"]').val()
                    };

                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: rowData, // Send only the current row data
                        success: function(response) {
                            if (response.success) {
                                // Display a success message
                                alert('Action completed successfully.');
                                $('#success').html();
                                // Disable the current row's input fields and button
                                currentRow.find('input, textarea, button').prop('disabled', true);
                            } else {
                                alert('Action failed. Please try again.');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('An error occurred. Please try again later.');
                        },
                        complete: function() {
                            // Hide the spinner and enable the button after the request completes
                            spinner.hide();
                            button.prop('disabled', true);
                        }
                    });
                });

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



// For Value Validate 
function valueValidate(inputElement, maxValue) {
    var currentValue = parseInt(inputElement.value);
    
    if (currentValue > maxValue) {
        alert('Entered value is greater than the remaining value.');
        inputElement.value = maxValue; // Set the value to the max value
    } else if (currentValue < 0) {
        alert('Value cannot be less than 0.');
        inputElement.value = 0; // Set the value to the minimum value
    }
}

// Inspect Page Lock
// Disable right-click context menu




// document.addEventListener('contextmenu', function(event) {
//     event.preventDefault();
// });

// // Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, and Ctrl+U (view source)
// document.addEventListener('keydown', function(event) {
//     // F12 key
//     if (event.keyCode === 123) {
//         event.preventDefault();
//     }
//     // Ctrl+Shift+I (Inspect)
//     if (event.ctrlKey && event.shiftKey && event.keyCode === 73) {
//         event.preventDefault();
//     }
//     // Ctrl+Shift+J (Console)
//     if (event.ctrlKey && event.shiftKey && event.keyCode === 74) {
//         event.preventDefault();
//     }
//     // Ctrl+U (View Source)
//     if (event.ctrlKey && event.keyCode === 85) {
//         event.preventDefault();
//     }
// });


</script>
@endpush

