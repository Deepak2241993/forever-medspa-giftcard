@extends('layouts.front_product')
@section('body')
@php
$cart = session()->get('cart', []);
$amount=0;
@endphp
{{-- {{dd(session()->get('giftcards'))}} --}}
   <!-- Body main wrapper start -->
   <main>

    <!-- Breadcrumb area start  -->
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
       <div class="breadcrumb__thumb" data-background="{{url('/product_page')}}/imgs/bg/breadcrumb-bg.jpg"></div>
       <div class="container">
          <div class="row justify-content-center">
             <div class="col-xxl-12">
                <div class="breadcrumb__wrapper text-center">
                   <h2 class="breadcrumb__title">Checkout</h2>
                   <div class="breadcrumb__menu">
                      <nav>
                         <ul>
                            <li><span><a href="{{url('/')}}">Home</a></span></li>
                            <li><span>checkout</span></li>
                         </ul>
                      </nav>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
    <!-- Breadcrumb area start  -->

    <!-- checkout-area start -->
    <section class="checkout-area section-space">
       <div class="container">
          <form action="{{ route('checkout_process') }}" method="POST">
            @csrf
             <div class="row">
                <div class="col-lg-6">
                   <div class="checkbox-form">
                      <h3 class="mb-15">Billing Details</h3>
                      <div class="row g-5">
           
                         <div class="col-md-6">
                            <div class="checkout-form-list">
                               <label>First Name <span class="required">*</span></label>
                               <input type="text" placeholder="" name="fname">
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="checkout-form-list">
                               <label>Last Name <span class="required">*</span></label>
                               <input type="text" placeholder="" name="lname">
                            </div>
                         </div>
                         <div class="col-md-12">
                            <div class="checkout-form-list">
                               <input type="text" placeholder="Apartment, suite, unit etc. (optional)" name="address2">
                            </div>
                         </div>
                         <div class="col-md-12">
                            <div class="checkout-form-list">
                               <label>Town / City <span class="required">*</span></label>
                               <input type="text" placeholder="Town / City" name="city">
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="checkout-form-list">
                               <label>State / County <span class="required">*</span></label>
                               <input type="text" placeholder="" name="country">
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="checkout-form-list">
                               <label>Postcode / Zip <span class="required">*</span></label>
                               <input type="text" placeholder="Postcode / Zip" name="zip_code">
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="checkout-form-list">
                               <label>Email Address <span class="required">*</span></label>
                               <input type="email" placeholder="" name="email">
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="checkout-form-list">
                               <label>Phone <span class="required">*</span></label>
                               <input type="text" placeholder="Phone">
                            </div>
                         </div>
           
                      </div>
           
                   </div>
                </div>
                <div class="col-lg-6">
                   <div class="your-order">
                      <h3>Your order</h3>
                      <div class="your-order-table table-responsive">
                         <table>
                            <thead>
                               <tr>
                                  <th class="product-name">Product</th>
                                  <th class="product-total">Total</th>
                               </tr>
                            </thead>
                            <tbody>
                              @foreach ($cart as $item) 

                              @php
                              $cart_data= App\Models\Product::find($item['product_id']);
                              $amount += $cart_data->discounted_amount;
                              
                              @endphp
                               <tr class="cart_item">
                                  <td class="product-name">
                                    {{$cart_data->product_name}}<strong class="product-quantity"> × {{$cart_data->session_number?$cart_data->session_number:1}} Sessions</strong>
                                  </td>
                                  <td class="product-total">
                                     <span class="amount">${{ number_format($amount, 2) }}</span>
                                  </td>
                               </tr>
                               @endforeach
                               
                            </tbody>
                            <tfoot>
                               <tr class="cart-subtotal">
                                  <th>Cart Subtotal</th>
                                  <td><span class="amount">${{ number_format($amount, 2) }}</span></td>
                               </tr>
                               
                               <tr class="order-total">
                                  <th>Order Total</th>
                                  <td><strong><span class="amount">${{ number_format($amount, 2) }}</span></strong>
                                  </td>
                               </tr>
                            </tfoot>
                         </table>
                      </div>

                      <div class="payment-method">
                         <div class="accordion" id="checkoutAccordion">
                            <div class="accordion-item">
                               <h2 class="accordion-header" id="checkoutOne">
                                  <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                     data-bs-target="#bankOne" aria-expanded="true" aria-controls="bankOne">
                                     Direct Bank Transfer
                                  </button>
                               </h2>
                               <div id="bankOne" class="accordion-collapse collapse show"
                                  aria-labelledby="checkoutOne" data-bs-parent="#checkoutAccordion">
                                  <div class="accordion-body">
                                     Make your payment directly into our bank account. Please use your
                                     Order ID
                                     as the payment reference. Your order won’t be shipped until the
                                     funds have
                                     cleared in our account.
                                  </div>
                               </div>
                            </div>
                            <div class="accordion-item">
                               <h2 class="accordion-header" id="paymentTwo">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                     data-bs-target="#payment" aria-expanded="false" aria-controls="payment">
                                     Cheque Payment
                                  </button>
                               </h2>
                               <div id="payment" class="accordion-collapse collapse" aria-labelledby="paymentTwo"
                                  data-bs-parent="#checkoutAccordion">
                                  <div class="accordion-body">
                                     Please send your cheque to Store Name, Store Street, Store Town,
                                     Store
                                     State / County, Store
                                     Postcode.
                                  </div>
                               </div>
                            </div>
                            <div class="accordion-item">
                               <h2 class="accordion-header" id="paypalThree">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                     data-bs-target="#paypal" aria-expanded="false" aria-controls="paypal">
                                     PayPal
                                  </button>
                               </h2>
                               <div id="paypal" class="accordion-collapse collapse" aria-labelledby="paypalThree"
                                  data-bs-parent="#checkoutAccordion">
                                  <div class="accordion-body">
                                     Pay via PayPal; you can pay with your credit card if you don’t have
                                     a
                                     PayPal account.
                                  </div>
                               </div>
                            </div>
                         </div>
                         <div class="order-button-payment mt-20">
                            <button class="fill-btn" type="submit">
                               <span class="fill-btn-inner">
                                  <span class="fill-btn-normal">Place order</span>
                                  <span class="fill-btn-hover">Place order</span>
                               </span>
                            </button>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </form>
       </div>
    </section>
    <!-- checkout-area end -->

 </main>
 <!-- Body main wrapper end -->

@endsection