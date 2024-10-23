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
                    {{-- <a href="{{route('medspa-gift.create')}}" class="btn btn-primary">Add More</a> --}}
                    <div class="card-header">
                        @if (session()->has('error'))
                            <p class="text-danger"> {{ session()->get('error') }}</p>
                        @endif
                        @if (session()->has('success'))
                            <p class="text-success"> {{ session()->get('success') }}</p>
                        @endif
                    </div>
                    <span class="text-success"id="response_msg"></span>
                    <div class="scroll-container">
                        <div style="overflow: scroll">
                            {{-- <div class="scroll-content"> --}}
                                @if($paginatedItems->count())
                                <table id="datatable-buttons" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Receiver Name</th>
                                            <th>Received From</th>
                                            <!--<th>Message</th>-->
                                            <th>Sender's Email</th>
                                            <th>Coupon Code</th>
                                            <th>Number of Giftcards</th>
                                            <th>Giftcard Total</th>
                                            <th>Discount</th>
                                            <th>Paid Amount</th>
                                            <th>Payment Status</th>
                                            <th>Transaction Id</th>
                                            <th>Generated Date & Time</th>
                                            <th>Giftcard Number</th>
                                            <th>Send Mail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($paginatedItems as $key=>$value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value['recipient_name'] ? $value['recipient_name'] : $value['your_name'] }}
                                                </td>
                                                <td>
                                                    @if ($value['payment_mode'] == 'Payment Gateway')
                                                        {{ $value['recipient_name'] ? $value['your_name'] : 'Self' }}
                                                    @else
                                                        {{ Auth::user()->user_token }}
                                                    @endif
                                                </td>
                                                <!--<td>{{ $value['recipient_name'] ? $value['message'] : 'NULL' }}</td>-->
                                                <td>{{ $value['recipient_name'] ? $value['receipt_email'] : 'Medspa' }}</td>
                                                <td class="text-uppercase">
                                                    {{ $value['coupon_code'] ? $value['coupon_code'] : '----' }}</td>
                                                <td>{{ $value['qty'] ? $value['qty'] : '----' }}</td>
                                                <td>{{ $value['amount'] ? '$' . $value['amount'] : '$ 0' }}</td>
                                                <td>{{ $value['discount'] ? '$' . $value['discount'] : '$ 0' }}</td>
                                                <td>{{ $value['transaction_amount'] ? '$' . $value['transaction_amount'] : '$ 0' }}
                                                </td>

                                                <td>
                                                    @if ($value['payment_status'] == 'succeeded')
                                                        <span
                                                            class="badge text-bg-success">{{ ucFirst($value['payment_status']) }}</span>
                                                    @elseif($value['payment_status'] == 'processing')
                                                        <span
                                                            class="badge text-bg-primary">{{ ucFirst($value['payment_status']) }}</span>
                                                        <a href="#">
                                                            <span class="badge text-bg-warning" data-bs-toggle="modal"
                                                                data-bs-target="#paymentUpdate_{{ $value['id'] }}"
                                                                onclick="modalopen({{ $value['id'] }}, '{{ $value['transaction_id'] }}')">Update
                                                                Status</span>
                                                        </a>
                                                    @elseif($value['payment_status'] == 'amount_capturable_updated')
                                                        <span
                                                            class="badge text-bg-warning">{{ ucFirst($value['payment_status']) }}</span>
                                                    @elseif($value['payment_status'] == 'payment_failed')
                                                        <span
                                                            class="badge text-bg-danger">{{ ucFirst($value['payment_status']) }}</span>
                                                    @else
                                                        <span class="badge text-bg-danger">Incompleted</span>
                                                    @endif
                                                </td>
                                                <td>{{ $value['transaction_id'] }}</td>

                                                <td><?php echo date('m-d-Y h:i:A', strtotime($value['created_at'])); ?></td>
                                                <td>
                                                    <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop_{{ $value['id'] }}"
                                                        onclick="cardview({{ $value['id'] }},'{{ $value['transaction_id'] }}')">
                                                        View Card
                                                    </a>
                                                   
                                                </td>
                                                <td>
                                                    @if ($value['payment_status'] == 'succeeded')
                                                        <a href="{{ route('Resendmail_view', ['id' => $value['id']]) }}"
                                                            class="btn btn-warning" id="mailsend_{{ $value['id'] }}">Mail
                                                            Resend</a>
                                                        {{-- <button class="btn btn-warning" type="button" id="mailsend_{{$value['id']}}" onclick="sendmail({{$value['id']}}, '{{$value['transaction_id']}}')"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span> Send</button> --}}
                                                    @endif
                                                </td>

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

                            <button type="button" class="btn btn-primary mt-3 paymentstatusbutton" id="paymentstatusbutton"
                                gift_id="gift_id_" onclick="updatestatus(event)"><span
                                    class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                                    style="display: none;"></span>Update</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    </script>
@endpush
