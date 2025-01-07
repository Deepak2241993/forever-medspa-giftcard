@extends('layouts.admin_layout')
@section('body')
    <!-- Body main wrapper start -->
    @php
        $cart = session()->get('cart', []);
        $amount = 0;

        // $cart = session()->pull('cart');

    @endphp
    
    @push('css')
        .cart-page-total {
        background-color: #f8f9fa; /* Light background to highlight the cart totals */
        border: 1px solid #ddd; /* Border around the totals section */
        padding: 20px;
        border-radius: 5px; /* Rounded corners */
        }

        .cart-page-total h2 {
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
        border-bottom: 1px solid #ddd; /* Line under heading */
        padding-bottom: 10px;
        }

        .cart-totals-list {
        list-style: none; /* Remove bullet points */
        padding: 0;
        margin: 0;
        }

        .cart-totals-item {
        display: flex; /* Flexbox to align items */
        justify-content: space-between; /* Space between label and value */
        padding: 10px 0; /* Spacing for each item */
        border-bottom: 1px solid #ddd; /* Line between items */
        }

        .cart-totals-item:last-child {
        border-bottom: none; /* Remove bottom line from last item */
        }

        .cart-totals-value {
        font-weight: bold; /* Bold values for emphasis */
        color: #333; /* Dark text color */
        }

        .fill-btn {
        display: block;
        width: 100%;
        text-align: center;
        margin-top: 20px;
        padding: 15px 0;
        background-color: #007bff; /* Primary button color */
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
        }

        .fill-btn:hover {
        background-color: #0056b3; /* Darker blue on hover */
        }

        .fill-btn-inner {
        display: inline-block;
        position: relative;
        }

        .fill-btn-hover {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none; /* Hide hover text */
        }

        .fill-btn:hover .fill-btn-hover {
        display: inline-block; /* Show hover text */
        }

        .fill-btn:hover .fill-btn-normal {
        display: none; /* Hide normal text on hover */
        }
    @endpush
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Program Sale

                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Program Sale</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i>
                                Add Unit/Add Program/Services
                            </h3>
                        </div>
                        <div class="card-body">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
                                    Create Unit
                                </button>
                                <button type="button" class="btn btn-primary"
                                    onclick="location.href='{{ route('program.index') }}';">
                                    Buy Programs
                                </button>
                                <button type="button" class="btn btn-warning"
                                    onclick="location.href='{{ route('unit.index') }}';">
                                    Buy Unit
                                </button>
                                <button type="button" class="btn btn-dark"
                                    onclick="location.href='{{ route('product.index') }}';">
                                    Buy Services
                                </button>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="" name="fname" Placeholder="Search Patient by Phone/Email">
                                    </div>
                                    <div class="col-md-6">
                                        <Button type="button" class="btn btn-block btn-outline-success">Search</Button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--  For Unit Create Modal --}}
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create Unit Quickly</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('create-unit-quickly') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-lg-6 self">
                                    <label for="product_name" class="form-label">Unit Name<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" id="product_name" required type="text"
                                        name="product_name" value="{{ isset($data) ? $data['product_name'] : '' }}"
                                        placeholder="Product Name" onkeyup="slugCreate()">
                                </div>
                                <div class="mb-3 col-lg-6 self">
                                    <label for="product_slug" class="form-label">Unit Slug<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="product_slug"
                                        value="{{ isset($data) ? $data['product_slug'] : '' }}" placeholder="Slug"
                                        id="product_slug">
                                </div>

                                <div class="mb-3 col-lg-6 self mt-2">
                                    <label for="amount" class="form-label">Unit Original Price<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="number" min="0" name="amount"
                                        value="{{ isset($data) ? $data['amount'] : '' }}" placeholder="Original Price"
                                        required step="0.01">
                                    <input class="form-control" type="hidden" min="0" name="id"
                                        value="{{ isset($data) ? $data['id'] : '' }}">
                                </div>
                                <div class="mb-3 col-lg-6 self mt-2">
                                    <label for="discounted_amount" class="form-label">Unit Discounted Price</label>
                                    <input class="form-control" type="number" min="0" name="discounted_amount"
                                        value="{{ isset($data) ? $data['discounted_amount'] : '' }}"
                                        placeholder="Discounted Price" step="0.01">

                                </div>
                                <div class="mb-3 col-lg-6 self">
                                    <label for="min_qty" class="form-label">Min Qty<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="number" min="1" name="min_qty"
                                        value="{{ isset($data) ? $data['min_qty'] : '1' }}"
                                        placeholder="Number Of Session" required>
                                </div>
                                <div class="mb-3 col-lg-6 self">
                                    <label for="max_qty" class="form-label">Max Qty<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="number" min="1" name="max_qty"
                                        value="{{ isset($data) ? $data['max_qty'] : '1' }}"
                                        placeholder="Number Of Session" required>
                                </div>
                                <div class="mb-3 col-lg-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" name="status" id='status'>
                                        <option
                                            value="1"{{ isset($data['status']) && $data['status'] == 1 ? 'selected' : '' }}>
                                            Active</option>
                                        <option
                                            value="0"{{ isset($data['status']) && $data['status'] == 0 ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-6">
                            <label for="giftcard_redemption" class="form-label">Giftcard Redeem</label>
                            <select class="form-control" name="giftcard_redemption" id="from">
                                <option value="1"
                                    {{ isset($data['giftcard_redemption']) && $data['giftcard_redemption'] == 1 ? 'selected' : '' }}>
                                    Yes</option>
                                <option value="0"
                                    {{ isset($data['giftcard_redemption']) && $data['giftcard_redemption'] == 0 ? 'selected' : '' }}>
                                    No</option>
                            </select>
                        </div>
                                <div class="mb-3 col-lg-6">
                                    <button class="btn btn-block btn-outline-primary form_submit" type="submit"
                                        id="submitBtn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
         {{--  For Unit Create Modal End --}}
    </section>

 
    <section class="content">
        <div class="row">
            <div class="col-md-12">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">bs-stepper</h3>
                </div>
                <div class="card-body p-0">
                  <div class="bs-stepper linear">
                    <div class="bs-stepper-header" role="tablist">
                      <!-- your steps here -->
                      <div class="step active" data-target="#logins-part">
                        <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger" aria-selected="true">
                          <span class="bs-stepper-circle"><i class="fa fa-shopping-cart"></i></span>
                          <span class="bs-stepper-label">Carts</span>
                        </button>
                      </div>
                      <div class="line"></div>
                      <div class="step" data-target="#patient-information">
                        <button type="button" class="step-trigger" role="tab" aria-controls="patient-information" id="patient-information-trigger" aria-selected="false" disabled="disabled">
                          <span class="bs-stepper-circle"><i class="nav-icon fas fa-heartbeat"></i></span>
                          <span class="bs-stepper-label">Patient Information</span>
                        </button>
                      </div>
                      <div class="line"></div>
                      <div class="step" data-target="#information-part">
                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger" aria-selected="false" disabled="disabled">
                          <span class="bs-stepper-circle"><i class="fa fa-credit-card"></i></span>
                          <span class="bs-stepper-label">Payment</span>
                        </button>
                      </div>
                    </div>
                    <div class="bs-stepper-content">
                      <!-- your steps content here -->
                      <div id="logins-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="logins-part-trigger">
                        
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>

                                            <th class="cart-product-name">Product / Unit Name</th>
                                            <th class="product-subtotal">Price</th>
                                            <th class="product-subtotal">Discounted Price</th>
                                            <th class="product-quantity">No.of Session</th>
                                            <th class="product-quantity">Total</th>
                                            <th class="product-remove">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $redeem = 0;
                                        @endphp
                                        @foreach ($cart as $key => $item)
                                            @php
                                                if ($item['type'] == 'unit') {
                                                    $cart_data = App\Models\ServiceUnit::find($item['id']);
                                                    $amount += $cart_data->amount;
                                                    $image = explode('|', $cart_data->product_image);
                                                    if ($cart_data->giftcard_redemption == 1) {
                                                        $redeem += 1; // Corrected increment logic
                                                    }
                                                }
                                                if ($item['type'] == 'product') {
                                                    $cart_data = App\Models\Product::find($item['id']);
                                                    $amount += $cart_data->amount;
                                                    $image = explode('|', $cart_data->product_image);
                                                    if ($cart_data->giftcard_redemption == 1) {
                                                        $redeem += 1; // Corrected increment logic
                                                    }
                                                }

                                            @endphp

                                            {{-- {{dd($cart_data)}} --}}
                                            <tr id="cart-item-{{ $cart_data->id }}">

                                                <td class="product-name">{{ $cart_data->product_name }}</td>
                                                <td class="product-price"><span
                                                        class="amount">{{ $cart_data->amount }}</span></td>
                                                <td class="product-price"><span
                                                        class="amount">{{ $cart_data->discounted_amount }}</span></td>
                                                <td class="product-price"><span class="amount">
                                                        <form action="#" class="update-cart-form"
                                                            data-id="{{ $item['id'] }}">

                                                            <input class="cart-input form-control" id="cart_qty_{{ $key }}"
                                                                type="number" value="{{ $item['quantity'] }}"
                                                                data-id="{{ $item['id'] }}"
                                                                min="{{ $cart_data->min_qty ?? 1 }}"
                                                                max="{{ $cart_data->max_qty ?? 1 }}">


                                                        </form>
                                                </td>
                                                <td>{{ "$" . $item['quantity'] * $cart_data->amount ?? "$" . $item['quantity'] * $cart_data->amount }}
                                                </td>


                                                <td>
                                                    <a href="javascript:void(0)"
                                                        onclick="updateCart({{ $item['id'] }},'{{ $item['type'] }}','{{ $key }}')"
                                                        class="btn btn-block btn-outline-success">Update</a>
                                                    <a href="javascript:void(0)"
                                                        onclick="removeFromCart('{{ $key }}')"
                                                        class="btn btn-block btn-outline-danger">Remove</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- <div class="row">
                                <div class="col-12">
                                    <div class="coupon-all">
                                        
                                        <div class="coupon d-flex align-items-center">
                                            <div class="row">

                                                @if ($redeem != 0)
                                                    <div class="col-9 mt-4">
                                                        <h5>Apply Giftcard</h5>
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <input id="gift_number_0"
                                                                    placeholder="Enter Gift Card Number" class="form-control"
                                                                    name="coupon_code" type="text" required>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input id="giftcard_amount_0" placeholder="$0.00"
                                                                    class="form-control" name="coupon_code" type="number"
                                                                    min="0" onkeyup="validateGiftAmount(this)"
                                                                    readonly style="padding-left: 22px;">

                                                            </div>
                                                            <div class="col-md-3">
                                                                <button onclick="validategiftnumber({{ 0 }})"
                                                                    class="btn btn-block btn-outline-success giftcartbutton" type="button">
                                                                    <i class="fa fa-check"
                                                                                aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <span class="text-danger mt-4" id="error_0"></span>
                                                                <span class="text-success mt-4" id="success_0"></span>
                                                            </div>
                                                            <div id="parentElement"></div>
                                                            <div class="col-md-5  mt-4 mb-4">
                                                                <button  class="btn btn-block btn-outline-primary" id="addGiftCardButton"
                                                                    type="button">Apply More
                                                                    Giftcard
                                                                    
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div> --}}


                            <div class="row">
                                <div class="col-lg-6 ml-auto">
                                    <div class="cart-page-total">
                                        <h2>Cart totals</h2>
                                        <ul class="cart-totals-list mb-20">
                                            <li class="cart-totals-item">Subtotal <span
                                                    class="cart-totals-value">${{ number_format($amount, 2) }}</span></li>
                                            {{-- <li class="cart-totals-item">Total Giftcard Applied <span class="cart-totals-value" id="giftcard_applied">$0</span></li> --}}
                                            <li class="cart-totals-item">Tax 0% <span class="cart-totals-value"
                                                    id="tax_amount">
                                                    @php
                                                        $taxamount = ($amount * 0) / 100;
                                                        echo "+$" . number_format($taxamount, 2);
                                                    @endphp
                                                </span></li>
                                            <li class="cart-totals-item">Total <span class="cart-totals-value"
                                                    id="totalValue">${{ number_format($amount + $taxamount, 2) }}</span>
                                            </li>
                                        </ul>
                                        <a class="fill-btn" href="javascript:void(0)" id="submitGiftCards">
                                            Proceed to checkout

                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <button class="btn btn-primary" onclick="stepper.next()">Next</button>
                      </div>
{{-- Patient Inforamtion --}}
                        <div id="patient-information" class="content" role="tabpanel" aria-labelledby="patient-information-trigger">
                            <div class="form-group">
                                <h5>Patient Details</h5>
                                <div class="row">
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" value="" name="fname" Placeholder="First Name">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" value="" name="lname" Placeholder="Last Name">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="email" class="form-control" value="" name="email" Placeholder="Email">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" value="" name="phone" Placeholder="Phone">
                                        </div>
                                    </div>
                                </div>
                                {{--  Table Data --}}
                                <h5 class="mb-4">Patient Giftcards</h5>
                                <table clss="table table-bordered table-striped"border="1">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Transaction Number</th>
                                            <th>Card Number</th>
                                            <th>Date</th>
                                            <th>Message</th>
                                            <th>Value Amount</th>
                                            <th>Actual Paid Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Transaction Number</td>
                                            <td>Card Number</td>
                                            <td>Date</td>
                                            <td>Message</td>
                                            <td>Value Amount</td>
                                            <td>Actual Paid Amount</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                            <button class="btn btn-primary" onclick="stepper.next()">Next</button>
                        </div>
                      <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                        <div class="form-group">
                            <h5>Patient Details</h5>
                            <div class="row">
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" value="" name="fname" Placeholder="First Name">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" value="" name="lname" Placeholder="Last Name">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="email" class="form-control" value="" name="email" Placeholder="Email">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" value="" name="phone" Placeholder="Phone">
                                    </div>
                                </div>
                            </div>
                            {{--  Table Data --}}
                            <h5 class="mb-4">Patient Giftcards</h5>
                            <table clss="table table-bordered table-striped"border="1">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Transaction Number</th>
                                        <th>Card Number</th>
                                        <th>Date</th>
                                        <th>Message</th>
                                        <th>Value Amount</th>
                                        <th>Actual Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Transaction Number</td>
                                        <td>Card Number</td>
                                        <td>Date</td>
                                        <td>Message</td>
                                        <td>Value Amount</td>
                                        <td>Actual Paid Amount</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                
              </div>
              <!-- /.card -->
            </div>
          </div>
    </section>


@endsection
@push('script')
    <script>
        //  Create Slug 
        function slugCreate() {
            $.ajax({
                url: '{{ route('slugCreate') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_name: $('#product_name').val(),
                },
                success: function(response) {
                    if (response.success) {
                        $('#product_slug').val(response.slug);
                    } else {
                        $('.showbalance').html(response.error).show();
                    }
                }
            });
        }
        // Create Slug End
        function removeFromCart(id) {
            // alert(id);
            $.ajax({
                url: '{{ route('cartremove') }}',
                method: "POST",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: id
                },
                success: function(response) {
                    if (response.success) {
                        // Update the cart view, e.g., remove the item from the DOM
                        $('#cart-item-' + id).remove();
                        alert(response.success);
                        location.reload();
                    } else {
                        alert(response.error);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('An error occurred. Please try again.');
                }
            });
        }



        //  Gift card validation code start

        $(document).ready(function() {
            // Initialize key to a starting value
            var key = 0;
            // Array to store gift card numbers
            var giftCardNumbers = [];

            // Attach the click event to the button
            $('#addGiftCardButton').click(function() {
                // Increment the key for each new set of input fields
                key++;

                var html = `
            <div class="row mt-5" id="row_${key}">
                <div class="col-md-5">
                    <input id="gift_number_${key}" placeholder="Enter Gift Card Number"
                        class="input-text" name="coupon_code" type="text" required>
                </div>
                <div class="col-md-3">
                    <input id="giftcard_amount_${key}" placeholder="$0.00"
                        class="input-text" name="coupon_code" type="number" min="0" onkeyup="validateGiftAmount(this)" onchange="validateGiftAmount(this)" readonly style="padding-left: 22px;">
                </div>
                <div class="col-md-3 mt-4" style="display:flex;">
                    <button onclick="validategiftnumber(${key})"
                         class="btn btn-block btn-outline-success giftcartbutton" type="button">
                        <span class="fill-btn-inner">
                            <span class="fill-btn-normal"><i class="fa fa-check" aria-hidden="true"></i></span>
                            <span class="fill-btn-hover"><i class="fa fa-check" aria-hidden="true"></i></span>
                        </span>
                    </button> 
                    |
                    <button 
                         class="btn btn-block btn-outline-danger giftcartdelete remove-button" type="button" data-key="${key}">
                        <span class="fill-btn-inner">
                            <span class="fill-btn-normal">X</span>
                            <span class="fill-btn-hover">X</span>
                        </span>
                    </button>
                </div>
                <div class="col-md-3 mt-4">
                </div>
                <div class="col-md-12">
                    <span class="text-danger mt-4" id="error_${key}"></span>
                    <span class="text-success mt-4" id="success_${key}"></span>
                </div>
            </div>
        `;

                // Append the HTML to the desired parent element
                $('#parentElement').append(html); // Use the actual ID of the parent element
            });

            // Event delegation for dynamically added Remove buttons
            $(document).on('click', '.remove-button', function() {
                var keyToRemove = $(this).data('key');
                // Remove gift card number from the array
                var giftNumberToRemove = $('#gift_number_' + keyToRemove).val();
                giftCardNumbers = giftCardNumbers.filter(num => num !== giftNumberToRemove);
                $('#row_' + keyToRemove).remove();
                sumValues();
            });

            // Function to validate gift card number
            window.validategiftnumber = function(key) {
                var giftNumber = $('#gift_number_' + key).val();

                // Check if the gift card number is not null or empty
                if (!giftNumber) {
                    alert('Gift Card Number cannot be empty!');
                    $('#error_' + key).html('Gift Card Number cannot be empty.');
                    $('#success_' + key).html('');
                    return;
                }

                if (giftCardNumbers.includes(giftNumber)) {
                    alert('Duplicate Gift Card Number.');
                    $('#gift_number_' + key).val('');
                    $('#error_' + key).html('Duplicate Gift Card Number.');
                    $('#success_' + key).html('');
                    return;
                }

                $.ajax({
                    url: '{{ route('giftcards-validate') }}',
                    method: "post",
                    dataType: "json",
                    data: {
                        _token: '{{ csrf_token() }}',
                        giftcardnumber: giftNumber,
                        user_token: 'FOREVER-MEDSPA',
                    },
                    success: function(response) {
                        if (response.status === 200) {
                            var totalValueText = $('#totalValue').text();
                            // Remove the '$' symbol and parse it as a number
                            var totalValue = parseFloat(totalValueText.replace('$', '').replace(',',
                                '').trim());
                            // alert(response.actual_paid_amount);
                            // alert(totalValue);
                            if (response.actual_paid_amount > totalValue) {
                                alert(
                                    "The giftcard amount can not be more than the cart total amount"
                                );
                                return false; // Stop the execution if invalid
                            }

                            // Add the gift card number to the array
                            giftCardNumbers.push(giftNumber);
                            console.log(response.success);
                            console.log(response.actual_paid_amount);
                            $('#success_' + key).html(
                                response.message);
                            $('#giftcard_amount_' + key).val(response.actual_paid_amount);
                            $('#giftcard_amount_' + key).removeAttr('readonly');
                            $('#giftcard_amount_' + key).attr('max', response.actual_paid_amount);
                            sumValues();
                            $('#error_' + key).html('');
                        } else {
                            alert('Invalid Giftcard. Please enter the correct number');
                            console.log(response.error);
                            $('#error_' + key).html(response.error ||
                                'Invalid Giftcard. Please enter the correct number');
                            $('#success_' + key).html('');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('An error occurred. Please try again.');
                        $('#error_' + key).html('An error occurred. Please try again.');
                        $('#success_' + key).html('');
                    }
                });
            };
        });

        // Gift card validatuon code end

        // Adding Value in session
        $(document).ready(function() {
            $('#submitGiftCards').click(function() {
                var giftCards = [];

                // Add the initial gift card input fields
                var initialGiftNumber = $('#gift_number_0').val();
                var initialGiftAmount = $('#giftcard_amount_0').val();

                if (initialGiftNumber && initialGiftAmount) {
                    giftCards.push({
                        number: initialGiftNumber,
                        amount: initialGiftAmount
                    });
                }

                // Add dynamically added gift card input fields
                $('#parentElement .row').each(function() {
                    var rowId = $(this).attr('id').split('_')[1];
                    var giftNumber = $('#gift_number_' + rowId).val();
                    var giftAmount = $('#giftcard_amount_' + rowId).val();

                    if (giftNumber && giftAmount) {
                        giftCards.push({
                            number: giftNumber,
                            amount: giftAmount
                        });
                    }
                });

                $.ajax({
                    url: '{{ route('checkout') }}',
                    method: "post",
                    dataType: "json",
                    data: {
                        _token: '{{ csrf_token() }}',
                        giftcards: giftCards,
                        total_gift_applyed: $('#giftcard_applied').html().replace(/[\$-]/g, '')
                            .trim(),
                        tax_amount: $('#tax_amount').html().replace(/[\$+]/g, '').trim(),
                        totalValue: $('#totalValue').html().replace(/[\$]/g, '').trim()

                    },
                    success: function(response) {
                        if (response.status === 200) {
                            window.location = "{{ route('checkout_view') }}";
                        } else {
                            alert('Error submitting Gift Cards: ' + response.error);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert(
                            'An error occurred while submitting the Gift Cards. Please try again.'
                        );
                    }
                });
            });
        });


        // Giftcard number adding in session 

        let alertShownCount = 0;

        function validateGiftAmount(inputElement) {
            // Retrieve the maximum allowed value
            var maxValue = parseFloat($(inputElement).attr('max'));
            // Retrieve the current value from the input
            var currentValue = parseFloat($(inputElement).val());

            // If currentValue exceeds maxValue, reset and handle alerts
            if (currentValue > maxValue) {
                if (alertShownCount === 0) {
                    alert('The value entered exceeds the maximum allowed value of ' + maxValue +
                        '. Please enter a valid amount.');
                    alertShownCount++;
                } else {
                    alert('The value entered exceeds the maximum allowed value of ' + maxValue +
                        '. The value has been set to the maximum.');
                }
                // Set the input value to the maximum allowed
                $(inputElement).val(maxValue);
            }

            // Call the sum calculation function to update totals
            sumValues();
        }

        // Sum Calculation Function
        function sumValues() {
            let sum = 0;

            // Iterate through all gift card amount inputs and calculate the sum
            $('input[id^="giftcard_amount_"]').each(function() {
                let value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    sum += value;
                }
            });

            // Retrieve the total value from the cart
            var total_value_from_cart = {{ $amount }};
            var new_final_amount = total_value_from_cart - sum;

            // Calculate the tax amount (10% of the new final amount)
            var taxamount = (new_final_amount * 0) / 100;

            // Update the display values on the page
            $('#totalValue').text('$' + (new_final_amount + taxamount).toFixed(2));
            $('#giftcard_applied').text('-$' + sum.toFixed(2));
            $('#tax_amount').text('+$' + taxamount.toFixed(2));
        }
    </script>



    {{-- For Cart Update --}}
    <script>
        // Update Cart
        function updateCart(itemId, itemType, cart_id) {
            var quantity = $('#cart_qty_' + cart_id).val();
            var min = parseInt($('#cart_qty_' + cart_id).attr('min')); // Get the min value
            var max = parseInt($('#cart_qty_' + cart_id).attr('max')); // Get the max value
            // alert(quantity);

            if (quantity <= 0) {
                alert("Quantity must be at least 1");
                return;
            }
            if (quantity < min || quantity > max) {
                alert('Quantity must be between ' + min + ' and ' + max + '.');
                location.reload();
                return false;
            }

            // Send AJAX request to update the cart
            $.ajax({
                url: '{{ route('update-cart') }}', // Replace with your actual route
                method: 'POST',
                data: {
                    id: itemId,
                    type: itemType,
                    quantity: quantity,
                    key: cart_id,
                    _token: '{{ csrf_token() }}' // CSRF token for security
                },
                success: function(response) {
                    if (response.status === '200') {
                        console.log("Cart updated successfully!");
                        location.reload();
                    } else {
                        alert(response.error || "Failed to update the cart.");
                    }
                },
                error: function() {
                    alert("An error occurred while updating the cart.");
                }
            });
        }


        // Event Listeners
        // $(document).on('click', '.cart-minus', function() {
        //     const input = $(this).closest('.update-cart-form').find('.cart-input');
        //     const itemId = input.data('id');
        //     let quantity = parseInt(input.val(), 10) - 1;
        //     input.val(quantity);
        //     updateCart(itemId, quantity);
        // });

        // $(document).on('click', '.cart-plus', function() {
        //     const input = $(this).closest('.update-cart-form').find('.cart-input');
        //     const itemId = input.data('id');
        //     let quantity = parseInt(input.val(), 10) + 1;
        //     input.val(quantity);
        //     updateCart(itemId, quantity);
        // });

        // $(document).on('keyup change', '.cart-input', function() {
        //     const itemId = $(this).data('id');
        //     const quantity = parseInt($(this).val(), 10);
        //     updateCart(itemId, quantity);
        // });
    </script>





    {{-- <script>
// Disable right-click context menu
document.addEventListener('contextmenu', function(event) {
    event.preventDefault();
});

// Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, and Ctrl+U (view source)
document.addEventListener('keydown', function(event) {
    // F12 key
    if (event.keyCode === 123) {
        event.preventDefault();
    }
    // Ctrl+Shift+I (Inspect)
    if (event.ctrlKey && event.shiftKey && event.keyCode === 73) {
        event.preventDefault();
    }
    // Ctrl+Shift+J (Console)
    if (event.ctrlKey && event.shiftKey && event.keyCode === 74) {
        event.preventDefault();
    }
    // Ctrl+U (View Source)
    if (event.ctrlKey && event.keyCode === 85) {
        event.preventDefault();
    }
});
</script>  --}}
