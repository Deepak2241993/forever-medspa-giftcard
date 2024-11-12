@extends('layouts.front_product')
@section('body')
    <!-- Body main wrapper start -->
    @php
        $cart = session()->get('cart', []);
        $amount = 0;
    @endphp
    <main>
        @push('css')
            .giftcartbutton {
            font-size: 14px;
            font-weight: var(--bd-fw-medium);
            color: var(--clr-common-white);
            background: #198754;
            height: 30px;
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 11px 27px;


            }
            .giftcartdelete{
            font-size: 14px;
            font-weight: var(--bd-fw-medium);
            color: var(--clr-common-white);
            background: #dc3545;
            height: 30px;
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 11px 27px;
            }
        @endpush
        <!-- Breadcrumb area start  -->
        <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
            <div class="breadcrumb__thumb" data-background="{{url('/uploads/FOREVER-MEDSPA')}}/med-spa-banner.jpg"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-12">
                        <div class="breadcrumb__wrapper text-center">
                            <h2 class="breadcrumb__title">Deals<br>Cart</h2>
                            <div class="breadcrumb__menu">
                                <nav>
                                    <ul>
                                        <li><span><a href="{{ url('/') }}">Home</a></span></li>
                                        <li><span>Deals Cart</span></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcrumb area start  -->
        @if (isset($cart) && !empty($cart))
            <!-- Cart area start  -->
            <div class="cart-area section-space">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-content table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">Images</th>
                                            <th class="cart-product-name">Product</th>
                                            {{-- <th class="product-price">Unit Price</th> --}}
                                            <th class="product-quantity">No.of Session</th>
                                            <th class="product-subtotal">Total</th>
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $redeem = 0;
                                        @endphp

                                        @foreach ($cart as $key => $item)
                                            @php
                                                $cart_data = App\Models\Product::find($item['product_id']);
                                                $amount += $cart_data->discounted_amount ? $cart_data->discounted_amount : $cart_data->amount;
                                                $image = explode('|', $cart_data->product_image);
                                                if ($cart_data->giftcard_redemption == 0) {
                                                    $redeem += 1; // Corrected increment logic
                                                }
                                            @endphp

                                            {{-- {{dd($cart_data)}} --}}
                                            <tr id="cart-item-{{ $cart_data->id }}">
                                                <td class="product-thumbnail"><a href="product-details.html"><img
                                                            src="{{ $image[0] }}" alt="img" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';"></a></td>
                                                <td class="product-name"><a
                                                        href="product-details.html">{{ $cart_data->product_name }}</a></td>
                                                {{-- <td class="product-price"><span class="amount">$24.00</span></td> --}}
                                                <td class="product-quantity text-center">
                                                    <div class="product-quantity mt-10 mb-10">
                                                        <div class="product-quantity-form">


                                                            <input class="cart-input" readonly type="text"
                                                                value="{{ $cart_data->session_number }}">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="product-subtotal"><span
                                                        class="amount">{{ $cart_data->discounted_amount ? $cart_data->discounted_amount : $cart_data->amount }}</span></td>
                                                <td class="product-remove">
                                                    <a href="javascript:void(0)"
                                                        onclick="removeFromCart({{ $item['product_id'] }})">
                                                        <i class="fa fa-trash"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="coupon-all">
                                        <div class="col-12">
                                            <div class="coupon2">
                                                <button
                                                    onclick="window.location.href='{{ route('category', 'FOREVER-MEDSPA') }}'"
                                                    class="fill-btn" type="button">
                                                    <span class="fill-btn-inner">
                                                        <span class="fill-btn-normal">+Add More</span>
                                                        <span class="fill-btn-hover">+Add More</span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="coupon d-flex align-items-center">
                                            <div class="row">
                                                {{-- {{dd($redeem);}} --}}
                                                @if ($redeem <= 0)
                                                    <div class="col-9 mt-4">
                                                        <h5>Apply Giftcard</h5>
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <input id="gift_number_0"
                                                                    placeholder="Enter Gift Card Number" class="input-text"
                                                                    name="coupon_code" type="text" required>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input id="giftcard_amount_0" placeholder="$0.00"
                                                                    class="input-text" name="coupon_code" type="number"
                                                                    min="0" onkeyup="validateGiftAmount(this)" onchange="validateGiftAmount(this)"
                                                                    readonly style="padding-left: 22px;">

                                                            </div>
                                                            <div class="col-md-3 mt-4">
                                                                <button onclick="validategiftnumber({{ 0 }})"
                                                                    class="btn btn-success giftcartbutton" type="button">
                                                                    <span class="fill-btn-inner">
                                                                        <span class="fill-btn-normal"><i class="fa fa-check"
                                                                                aria-hidden="true"></i></span>
                                                                        <span class="fill-btn-hover"><i class="fa fa-check"
                                                                                aria-hidden="true"></i></span>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <span class="text-danger mt-4" id="error_0"></span>
                                                                <span class="text-success mt-4" id="success_0"></span>
                                                            </div>
                                                            <div id="parentElement"class="mt-4"></div>
                                                            <div class="col-md-5  mt-4">
                                                                <button class="fill-btn" id="addGiftCardButton"
                                                                    type="button">
                                                                    <span class="fill-btn-inner">
                                                                        <span class="fill-btn-normal">Apply More
                                                                            Giftcard</span>
                                                                        <span class="fill-btn-hover">Apply More
                                                                            Giftcard</span>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6 ml-auto">
                                    <div class="cart-page-total">
                                        <h2>Cart totals</h2>
                                        <ul class="mb-20">
                                            <li>Subtotal <span>${{ number_format($amount, 2) }}</span></li>
                                            <li>Total Giftcard Applied <span id="giftcard_applied">$0</span></li>
                                            <li>Tax 10% <span id="tax_amount">
                                                    @php
                                                        $texamount = ($amount * 10) / 100;
                                                        echo "+$" . $texamount;
                                                    @endphp
                                                </span></li>
                                            <li>Total <span
                                                    id="totalValue">${{ number_format($amount + $texamount, 2) }}</span>
                                            </li>
                                        </ul>
                                        <a class="fill-btn" href="javascript:void()" id="submitGiftCards">
                                            <span class="fill-btn-inner">
                                                <span class="fill-btn-normal">Proceed to checkout</span>
                                                <span class="fill-btn-hover">Proceed to checkout</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="disclamer" style="margin-top:50px">
                    <hr>
                    <p>
                    <b class="mt-2">Disclaimer: Giftcards are only applicable if all the services added in the cart has the Giftcard redeem offer activated.
                    For any queries please contact <a href="mailto:admin@forevermedspanj.com">admin@forevermedspanj.com </a></b> 
                    </p>
                    <hr/>
                    </div>
                </div>
                
            </div>
            <!-- Cart area end  -->
        @else
            <h3>Your Cart is Empty</h3>
        @endif

    </main>
    <!-- Body main wrapper end -->

@endsection

@push('footerscript')
    <script>
        function removeFromCart(id) {
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
                        class="btn btn-success giftcartbutton" type="button">
                        <span class="fill-btn-inner">
                            <span class="fill-btn-normal"><i class="fa fa-check" aria-hidden="true"></i></span>
                            <span class="fill-btn-hover"><i class="fa fa-check" aria-hidden="true"></i></span>
                        </span>
                    </button> 
                    |
                    <button 
                        class="btn btn-danger giftcartdelete remove-button" type="button" data-key="${key}">
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
                            // Add the gift card number to the array
                            giftCardNumbers.push(giftNumber);

                            console.log(response.success);
                            console.log(response.actual_paid_amount);
                            $('#success_' + key).html(
                                'Your total available amount is $' +
                                response.actual_paid_amount);
                            $('#giftcard_amount_' + key).val(response.actual_paid_amount);
                            $('#giftcard_amount_' + key).removeAttr('readonly');
                            $('#giftcard_amount_' + key).attr('max', response.actual_paid_amount);
                            sumValues();
                            $('#error_' + key).html('');
                        } else {
                            alert('Invalid Giftcard. Please enter the correct number');
                            console.log(response.error);
                            $('#error_' + key).html(response.error || 'Invalid Giftcard. Please enter the correct number');
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
                            'An error occurred while submitting the Gift Cards. Please try again.');
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
            alert('The value entered exceeds the maximum allowed value of ' + maxValue + '. Please enter a valid amount.');
            alertShownCount++;
        } else {
            alert('The value entered exceeds the maximum allowed value of ' + maxValue + '. The value has been set to the maximum.');
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
    var taxamount = (new_final_amount * 10) / 100;

    // Update the display values on the page
    $('#totalValue').text('$' + (new_final_amount + taxamount).toFixed(2));
    $('#giftcard_applied').text('-$' + sum.toFixed(2));
    $('#tax_amount').text('+$' + taxamount.toFixed(2));
}

    </script>
<script>
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
</script> 
@endpush
