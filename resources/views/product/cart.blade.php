@extends('layouts.front_product')
@section('body')
<!-- Body main wrapper start -->
@php
$cart = session()->get('cart', []);
$amount=0;
@endphp
<main>

    <!-- Breadcrumb area start  -->
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
       <div class="breadcrumb__thumb" data-background="{{url('/product_page')}}/imgs/bg/breadcrumb-bg.jpg"></div>
       <div class="container">
          <div class="row justify-content-center">
             <div class="col-xxl-12">
                <div class="breadcrumb__wrapper text-center">
                   <h2 class="breadcrumb__title">Cart</h2>
                   <div class="breadcrumb__menu">
                      <nav>
                         <ul>
                            <li><span><a href="{{url('/')}}">Home</a></span></li>
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
@if(isset($cart) && !empty($cart))
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
                    
                          @foreach ($cart as $item) 

                          @php
                          $cart_data= App\Models\Product::find($item['product_id']);
                          $amount += $cart_data->discounted_amount;
                          
                          @endphp
                          {{-- {{dd($cart_data)}} --}}
                         <tr id="cart-item-{{ $cart_data->id }}">
                            <td class="product-thumbnail"><a href="product-details.html"><img
                                     src="{{$cart_data->product_image}}" alt="img"></a></td>
                            <td class="product-name"><a href="product-details.html">{{$cart_data->product_name}}</a></td>
                            {{-- <td class="product-price"><span class="amount">$24.00</span></td> --}}
                            <td class="product-quantity text-center">
                               <div class="product-quantity mt-10 mb-10">
                                  <div class="product-quantity-form">
                                    
                                        <input class="cart-input" readonly type="text" value="{{$cart_data->session_number}}">
                                  </div>
                               </div>
                            </td>
                            <td class="product-subtotal"><span class="amount">{{$cart_data->discounted_amount}}</span></td>
                            <td class="product-remove"><a href="#"onclick="removeFromCart({{ $item['product_id'] }})"><i class="fa fa-times"></i></a></td>
                         </tr>
                         @endforeach
                         
                       
                      </tbody>
                   </table>
                </div>
                
                <div class="row">
                   <div class="col-12">
                      <div class="coupon-all">
                         
                         <div class="coupon2">
                           <button onclick="window.location.href='{{ route('category', 'FOREVER-MEDSPA') }}'" class="fill-btn" type="button">
                              <span class="fill-btn-inner">
                                  <span class="fill-btn-normal">+Add More</span>
                                  <span class="fill-btn-hover">+Add More</span>
                              </span>
                          </button>
                          
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
                            <li>Shipping <span>$10.00</span></li>
                            <li>Tax <span>$10.00</span></li>
                            <li>Total <span>${{ number_format($amount, 2) }}</span></li>
                         </ul>
                         <a class="fill-btn" href="{{route('checkout')}}">
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
       method: "post",
       dataType: "json",
       data: {
           _token: '{{ csrf_token() }}',
           product_id: id
       },
       success: function (response) {
           if (response.success) {
               // Update the cart view, e.g., remove the item from the DOM
               $('#cart-item-' + id).remove();
               alert(response.success);
               location.reload();
           } else {
               alert(response.error);
           }
       },
       error: function (jqXHR, textStatus, errorThrown) {
           alert('An error occurred. Please try again.');
       }
   });
}
</script>
@endpush