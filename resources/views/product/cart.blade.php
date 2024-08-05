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
            <div class="breadcrumb__thumb" data-background="{{ url('/product_page') }}/imgs/bg/breadcrumb-bg.jpg"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-12">
                        <div class="breadcrumb__wrapper text-center">
                            <h2 class="breadcrumb__title">Cart</h2>
                            <div class="breadcrumb__menu">
                                <nav>
                                    <ul>
                                        <li><span><a href="{{ url('/') }}">Home</a></span></li>
                                        <li><span>Cart</span></li>
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
                                        @foreach ($cart as $key => $item)
                                            @php
                                                $redeem=0;
                                                $cart_data = App\Models\Product::find($item['product_id']);
                                                $amount += $cart_data->discounted_amount;
                                                $image = explode('|', $cart_data->product_image);
                                                if ($cart_data->giftcard_redemption == 1) {
                                                    $redeem=1;
                                                }

                                            @endphp
                                           
                                            {{-- {{dd($cart_data)}} --}}
                                            <tr id="cart-item-{{ $cart_data->id }}">
                                                <td class="product-thumbnail"><a href="product-details.html"><img
                                                            src="{{ $image[0] }}" alt="img"></a></td>
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
                                                        class="amount">{{ $cart_data->discounted_amount }}</span></td>
                                                <td class="product-remove">
                                                    <a  href="javascript:void(0)" onclick="removeFromCart({{ $item['product_id'] }})">
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
                                        @if($redeem != 0)
                                            <div class="coupon d-flex align-items-center">
                                                <div class="row">
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
                                                    <div class="col-9 mt-4">
                                                        <h5>Apply Giftcard</h5>
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <input id="gift_number_0"
                                                                    placeholder="Enter Gift Card Number" class="input-text"
                                                                    name="coupon_code" type="text" required>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input id="giftcard_amount_0" placeholder="$0.00"
                                                                    class="input-text" name="coupon_code" type="number"
                                                                    min="0" value="0"
                                                                    onkeyup="validateGiftAmount(this)">

                                                            </div>
                                                            <div class="col-md-3 mt-4">
                                                                <button onclick="validategiftnumber({{ 0 }})"
                                                                    class="btn btn-success giftcartbutton" type="button">
                                                                    <span class="fill-btn-inner">
                                                                        <span class="fill-btn-normal"><i class="fa fa-check" aria-hidden="true"></i></span>
                                                                        <span class="fill-btn-hover"><i class="fa fa-check" aria-hidden="true"></i></span>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <span class="text-danger mt-4" id="error_0"></span>
                                                                <span class="text-success mt-4" id="success_0"></span>
                                                            </div>
                                                            <div id="parentElement"></div>
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
                                                    
                                                </div>
                                            </div>
                                        @endif
                                     
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
                                                        $discountedprice = ($amount * 10) / 100;
                                                        echo "+$" . $discountedprice;
                                                    @endphp
                                                </span></li>
                                            <li>Total <span
                                                    id="totalValue">${{ number_format($amount + $discountedprice, 2) }}</span>
                                            </li>
                                        </ul>
                                        <a class="fill-btn" href="{{ route('checkout') }}">
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


        // For Validate Gift Number

        function validategiftnumber(key) {
            $.ajax({
                url: '{{ route('giftcards-validate') }}',
                method: "post",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    name: "",
                    email: "",
                    giftcardnumber: $('#gift_number_' + key).val(),
                    user_token: 'FOREVER-MEDSPA',
                },
                success: function(response) {
                    if (response.status === 200) {
                        // Update the cart view, e.g., remove the item from the DOM
                        console.log(response.success);
                        console.log(response.result.total_amount);
                        $('#success_' + key).html('This Gift Card is valid. Your total available amount is $' +
                            response.result.total_amount);
                        $('#giftcard_amount_' + key).val(response.result.total_amount);
                        $('#giftcard_amount_' + key).attr('max', response.result.total_amount);
                        sumValues();
                    } else {
                        alert('Invalid Gift Card');
                        console.log(response.error);
                        $('#error_' + key).html(response.error || 'An error occurred');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('An error occurred. Please try again.');
                }
            });
        }


        // Attach the click event to the button
        $(document).ready(function() {
            // Initialize key to a starting value
            var key = 0;

            // Attach the click event to the button
            $('#addGiftCardButton').click(function() {
                // Increment the key for each new set of input fields
                key++;

                var html = `
       <div class="row mt-4">
        <div class="col-md-5">
          <input id="gift_number_${key}" placeholder="Enter Gift Card Number"
                class="input-text" name="coupon_code" type="text" required>
       </div>
       <div class="col-md-2">
          <input id="giftcard_amount_${key}" placeholder="$0.00"
                class="input-text" name="coupon_code" type="number" min="0" value="0">
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
          <button onclick="validategiftnumber(${key})"
                class="btn btn-danger giftcartdelete" type="button">
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
                $('#row_' + keyToRemove).remove();
            });
        });


        let alertShownCount = 0;

        function validateGiftAmount(inputElement) {
            var maxValue = parseFloat($(inputElement).attr('max'));
            var currentValue = parseFloat($(inputElement).val());
            sumValues();
            if (currentValue > maxValue) {
                if (alertShownCount === 0) {
                    alert('The value entered exceeds the maximum allowed value of ' + maxValue +
                        '. Please enter a valid amount.');
                    alertShownCount++;
                    $(inputElement).val(maxValue);
                } else {
                    $(inputElement).val(maxValue);
                    // $(inputElement).prop('disabled', true);
                    alert('The value entered exceeds the maximum allowed value of ' + maxValue +
                        '. The value has been set to the maximum and the input field is now disabled.');
                }
            }
        }

        //  For Sum Calculation
        function sumValues() {
            let sum = 0;

            $('input[id^="giftcard_amount_"]').each(function() {
                let value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    sum += value;
                }
            });

            var total_value_from_cart = {{ $amount }};
            var new_final_amount = (total_value_from_cart - sum);

            // Tax calculation 10%
            var taxamount = (new_final_amount * 10) / 100;

            $('#totalValue').text('$' + (new_final_amount + taxamount));
            $('#giftcard_applied').text('-$' + sum);
            $('#giftcard_applied').text('-$' + sum);
            $('#tax_amount').text('+$' + taxamount);
            //  $('#totalValue').text('Total Value: $' + sum.toFixed(2));
        }
    </script>
@endpush
