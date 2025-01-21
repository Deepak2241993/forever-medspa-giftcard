@extends('layouts.admin_layout')
@section('body')
    <style>
        .scroll-container {
            width: 100%;
            /* Set the width of the container */
            overflow-x: auto;
            /* Enable horizontal scrolling */
            white-space: nowrap;
            /* Make sure all elements are in one line */
        }

        .scroll-content {
            display: inline-block;
            /* Make sure content stays in one line */
            /* Optionally set a min-width to prevent content from squishing */
            min-width: 100%;
            /* Set to the width of your content */
        }

        .swal-text {
            font-size: 21px;
            position: relative;
            float: none;
            line-height: normal;
            vertical-align: top;
            text-align: left;
            display: inline-block;
            margin: 0;
            padding: 0 10px;
            font-weight: 700;
            color: #0e0e0f;
            /* max-width: calc(100% - 20px); */
            /* overflow-wrap: break-word; */
            box-sizing: border-box;
        }
    </style>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
              <h3 class="mb-0">All Giftcards Transactions</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('admin-dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Giftcards Transactions
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
            <!--begin::Container-->
            <section class="content">
                <div class="container-fluid">

                    <!--begin::Row-->
                    {{-- <a href="{{route('medspa-gift.create')}}"  class="btn btn-block btn-outline-primary">Add More</a> --}}
                    <div class="card-header">
                        @if (session()->has('error'))
                            <p class="text-danger"> {{ session()->get('error') }}</p>
                        @endif
                        @if (session()->has('success'))
                            <p class="text-success"> {{ session()->get('success') }}</p>
                        @endif
                    </div>
                    <span class="text-success"id="response_msg"></span>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Search Data</h4>
                        </div>
                        <div class="card-body"> 
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="recipient_name" name="recipient_name" placeholder="Enter Gift Card Holder Name" onkeyup="SearchView()">
                                        </div>
                                        <div class="col-md-6">
                                        
                                            <input type="text" class="form-control" id="receipt_email" name="receipt_email" placeholder="Enter Gift Card Holder Email" onkeyup="SearchView()">
                                        </div>
                                        
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="scroll-container">
                        <div style="overflow: scroll">
                            {{-- <div class="scroll-content"> --}}
                                @if($paginatedItems->count())
                                <table id="datatable-buttons" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Giftcard Number</th>
                                            <th>Send Mail</th>
                                            <th>Sender Name</th>
                                            <th>Receiver Name</th>
                                            <!--<th>Message</th>-->
                                            <th>Number of Giftcards</th>
                                            <th>Giftcard Value</th>
                                            <th>Discount</th>
                                            <th>Coupon Code</th>
                                            <th>Paid Amount</th>
                                            <th>Payment Status</th>
                                            <th>Transaction Id</th>
                                            <th>Generated Date & Time</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-table-body">
                                        @foreach($paginatedItems as $key=>$value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if($value['payment_status'] == 'succeeded')
                                                    <a type="button"  class="btn btn-block btn-outline-primary" data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop_{{ $value['id'] }}"
                                                        onclick="cardview({{ $value['id'] }},'{{ $value['transaction_id'] }}')">
                                                        View Card
                                                    </a>
                                                    @else
                                                    <a type="button"  class="btn btn-block btn-outline-danger">
                                                    No Payment
                                                </a>
                                                @endif
                                                   
                                                </td>
                                                <td>
                                                    @if ($value['payment_status'] == 'succeeded')
                                                        <a href="{{ route('Resendmail_view', ['id' => $value['id']]) }}"
                                                             class="btn btn-block btn-outline-warning" id="mailsend_{{ $value['id'] }}">Mail
                                                            Resend</a>
                                                        {{-- <button  class="btn btn-block btn-outline-warning" type="button" id="mailsend_{{$value['id']}}" onclick="sendmail({{$value['id']}}, '{{$value['transaction_id']}}')"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span> Send</button> --}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($value['payment_mode'] == 'Payment Gateway')
                                                    {!! $value['recipient_name'] ? $value['your_name'] : "<span class='badge bg-primary'>Self</span>" !!}

                                                    @else
                                                    <span class='badge bg-warning'>{!! Auth::user()->user_token !!}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $value['recipient_name'] ? $value['recipient_name'] : $value['your_name'] }}
                                                </td>
                                                <!--<td>{{ $value['recipient_name'] ? $value['message'] : 'NULL' }}</td>-->

                                                <td>{{ $value['qty'] ? $value['qty'] : '----' }}</td>
                                                <td>{{ $value['amount'] ? '$' . $value['amount'] : '$ 0' }}</td>
                                                <td>{{ $value['discount'] ? '$' . $value['discount'] : '$ 0' }}</td>
                                                <td class="text-uppercase">
                                                    {{ $value['coupon_code'] ? $value['coupon_code'] : '----' }}</td>
                                                <td>{{ $value['transaction_amount'] ? '$' . $value['transaction_amount'] : '$ 0' }}
                                                </td>

                                                <td>
                                                    @if ($value['payment_status'] == 'succeeded')
                                                        <span
                                                            class="badge bg-success">{{ ucFirst($value['payment_status']) }}</span>
                                                    @elseif($value['payment_status'] == 'processing')
                                                        <span
                                                            class="badge bg-primary">{{ ucFirst($value['payment_status']) }}</span>
                                                        <a href="#">
                                                            <span class="badge bg-warning" data-bs-toggle="modal"
                                                                data-bs-target="#paymentUpdate_{{ $value['id'] }}"
                                                                onclick="modalopen({{ $value['id'] }}, '{{ $value['transaction_id'] }}')">Update
                                                                Status</span>
                                                        </a>
                                                    @elseif($value['payment_status'] == 'amount_capturable_updated')
                                                        <span
                                                            class="badge bg-warning">{{ ucFirst($value['payment_status']) }}</span>
                                                    @elseif($value['payment_status'] == 'payment_failed')
                                                        <span
                                                            class="badge bg-danger">{{ ucFirst($value['payment_status']) }}</span>
                                                    @else
                                                        <span class="badge bg-danger">Incompleted</span>
                                                    @endif
                                                </td>
                                                <td>{{ $value['transaction_id'] }}</td>

                                                <td><?php echo date('m-d-Y h:i:A', strtotime($value['created_at'])); ?></td>
                                                

                                                <!-- Button trigger modal -->
                                            </tr>
                                        @endforeach
                                        <br>
                                        {{ $paginatedItems->links() }}
                                    </tbody>
                                </table>
                                {{ $paginatedItems->links() }}
                            @else
                                <hr>
                                <p> No data found</p>
                            @endif

                        </div>
                    </div>
                </div>
                <!-- /.row (main row) -->
            </section>
        </div>
        <!--end::Container-->
    </section>
    {{-- for payment status update modal --}}
    <div class="modal fade paymentUpdate" id="paymentUpdate_" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="paymentstatus" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentstatus">Payment Status Update</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div style="display: flex; flex-direction: column;">
                            <label for="transaction_id_" style="margin-right: 10px;">Transaction id:</label>
                            <input class="transaction_id form-control" type="text" id="transaction_id_" name="giftnumber"
                                value="" style="margin-right: 20px;" readonly>

                            <label for="payment_status_" style="margin-right: 10px;">Update Status</label>
                            <select name="payment_status" class="form-control status_id" id="payment_status_">
                                <option value="">Select Status</option>
                                <option value="succeeded">Succeeded</option>
                                <option value="processing">Processing</option>
                            </select>

                            <label for="comments_" style="margin-right: 10px;">Comments</label>
                            <textarea class="form-control comments_" name="comments" id="comments_" style="margin-right: 20px;"></textarea>

                            <input type="hidden" class="user_token" name="user_token"
                                value="{{ Auth::user()->user_token }}">
                            <input type="hidden" class="gift_id" id="gift_id_" name="id" value="">

                            <button type="button"  class="btn btn-block btn-outline-primary mt-3 paymentstatusbutton" id="paymentstatusbutton"
                                gift_id="gift_id_" onclick="updatestatus(event)"><span
                                    class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                                    style="display: none;"></span>Update</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                   <button type="button"  class="btn btn-block btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Paymnet status update modal End --}}


    <!-- for Show Gift card Number Modal -->
    <div class="modal fade deepak" id="staticBackdrop_" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Gift Card Number</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
                </div>
                <div class="modal-body">
                    <h2 id="giftcardsshow"></h2>
                </div>
                <div class="modal-footer">
                   <button type="button"  class="btn btn-block btn-default" data-dismiss="modal">Close</button>
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
        // for payment status Modal Open
        function modalopen(id, transaction_id) {
            $('#paymentUpdate_').attr('id', 'paymentUpdate_' + id);
            $('#transaction_id_').attr('id', 'transaction_id_' + id).val();
            $('#transaction_id_' + id).val(transaction_id);
            $('#payment_status_').attr('id', 'payment_status_' + id).val();
            $('.paymentstatusbutton').attr('id', 'paymentstatusbutton_' + id).val();
            $('.paymentstatusbutton').attr('gift_id', id).val();
            $('#gift_id_').attr('id', 'gift_id_' + id).val(id);
            $('#comments_').attr('id', 'comments_' + id).val();
            $('#paymentUpdate_' + id).modal('show');

        }

        function updatestatus(event) {
            var id = event.target.getAttribute('gift_id');
            var button = $('#paymentstatusbutton_' + id);
            button.attr('disabled', true);
            button.find('.spinner-border').show();
            $.ajax({
                url: '{{ route('giftcard-payment-update') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    transaction_id: $('#transaction_id_' + id).val(),
                    id: $('#gift_id_' + id).val(),
                    comments: $('#comments_' + id).val(),
                    user_token: '{{ Auth::user()->user_token }}',
                    payment_status: $('#payment_status_' + id).val(),
                },
                success: function(response) {
                    console.log(response.msg);
                    if (response) {
                        $('#paymentUpdate_' + id).modal('hide');
                        $('#response_msg').html(response.msg);
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                },
                complete: function() {
                    button.attr('disabled', false); // Enable button after AJAX call
                    button.find('.spinner-border').hide();
                }
            });
        }



        function cardview(id, tid) {
            $('.deepak').attr('id', 'staticBackdrop_' + id);
            $('#staticBackdrop_' + id).modal('show');

            $.ajax({
                url: '{{ route('cardview-route') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    tid: tid,
                    user_token: '{{ Auth::user()->user_token }}',
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

        //  
        function sendmail(id, tid) {
            //  For adding spinner
            var button = $('#mailsend_' + id);
            button.attr('disabled', true);
            button.find('.spinner-border').show();
            // spinner code end

            $.ajax({
                url: '{{ route('Resendmail_view') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    tid: tid,
                    id: id,
                    user_token: '{{ Auth::user()->user_token }}',
                },
                success: function(response) {
                    console.log(response.message);
                    if (response.message) {
                        swal("", response.message, "success");
                        button.attr('disabled', false);
                        button.find('.spinner-border').hide();
                    } else {
                        swal("", response.error, "error");
                        button.attr('disabled', false);
                        button.find('.spinner-border').hide();
                    }
                }
            });
        }

        function SearchView() {
    var recipient_name = $('#recipient_name').val();
    var receipt_email = $('#receipt_email').val();

    $.ajax({
        url: '{{ route('gift-card-transaction-search') }}', // API endpoint
        method: "GET",
        dataType: "json",
        data: {
            recipient_name: recipient_name,
            receipt_email: receipt_email
        },
        success: function (response) {
            if (response.status === 'success' && response.data.data.length > 0) {
                var tableBody = $('#data-table-body'); // ID of your table body
                tableBody.empty(); // Clear existing rows

                // Loop through the response data and populate the table
                $.each(response.data.data, function (key, value) {
                    // Format date
                    var updatedDate = value.updated_at
                        ? new Date(value.updated_at).toLocaleString('en-US', {
                            month: '2-digit',
                            day: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit',
                        })
                        : 'N/A';

                    // Handle product images dynamically
                    var productImages = value.product_image ? value.product_image.split('|') : [];
                    var firstImage = productImages.length > 0 ? productImages[0] : '{{ url("/No_Image_Available.jpg") }}';

                    // Handle payment status
                    var paymentStatusBadge = '';
                    if (value.payment_status === 'succeeded') {
                        paymentStatusBadge = '<span class="badge bg-success">' + value.payment_status.charAt(0).toUpperCase() + value.payment_status.slice(1) + '</span>';
                    } else if (value.payment_status === 'processing') {
                        paymentStatusBadge = '<span class="badge bg-primary">' + value.payment_status.charAt(0).toUpperCase() + value.payment_status.slice(1) + '</span>';
                    } else {
                        paymentStatusBadge = '<span class="badge bg-danger">Incompleted</span>';
                    }

                    // Append rows
                    tableBody.append(`
                        <tr>
                            <td>${key + 1}</td>
                            <td>${value.recipient_name || value.your_name}</td>
                            <td>${value.payment_mode === 'Payment Gateway' ? (value.recipient_name ? value.your_name : 'Self') : '{{ Auth::user()->user_token }}'}</td>
                            <td>${value.receipt_email || 'Medspa'}</td>
                            <td class="text-uppercase">${value.coupon_code || '----'}</td>
                            <td>${value.qty || '----'}</td>
                            <td>${value.amount ? '$' + value.amount : '$ 0'}</td>
                            <td>${value.discount ? '$' + value.discount : '$ 0'}</td>
                            <td>${value.transaction_amount ? '$' + value.transaction_amount : '$ 0'}</td>
                            <td>${paymentStatusBadge}</td>
                            <td>${value.transaction_id}</td>
                            <td>${new Date(value.created_at).toLocaleString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' })}</td>
                            <td>
                                <a type="button" class="btn btn-block btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop_${value.id}" onclick="cardview(${value.id},'${value.transaction_id}')">
                                    View Card
                                </a>
                            </td>
                        </tr>
                    `);
                });
            } else {
                // Handle empty results
                $('#data-table-body').empty().append('<tr><td colspan="9">No results found.</td></tr>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            alert('An error occurred while fetching data.');
        },
    });
}




    </script>
@endpush
