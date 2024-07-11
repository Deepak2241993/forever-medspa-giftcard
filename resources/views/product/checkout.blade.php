@extends('layouts.front_product')
@section('body')
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
                            <li><span><a href="index.html">Home</a></span></li>
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
          <form action="#">
             <div class="row">
                <div class="col-lg-6">
                   <div class="checkbox-form">
                      <h3 class="mb-15">Billing Details</h3>
                      <div class="row g-5">
                         <div class="col-md-12">
                            <div class="country-select">
                               <label>Country <span class="required">*</span></label>
                               <select>
                                  <option value="volvo">United States</option>
                                  <option value="saab">Algeria</option>
                                  <option value="mercedes">Afghanistan</option>
                                  <option value="audi">Ghana</option>
                                  <option value="audi2">Albania</option>
                                  <option value="audi3">Bahrain</option>
                                  <option value="audi4">Colombia</option>
                                  <option value="audi5">Dominican Republic</option>
                               </select>
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="checkout-form-list">
                               <label>First Name <span class="required">*</span></label>
                               <input type="text" placeholder="">
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="checkout-form-list">
                               <label>Last Name <span class="required">*</span></label>
                               <input type="text" placeholder="">
                            </div>
                         </div>
                         <div class="col-md-12">
                            <div class="checkout-form-list">
                               <label>Company Name</label>
                               <input type="text" placeholder="">
                            </div>
                         </div>
                         <div class="col-md-12">
                            <div class="checkout-form-list">
                               <label>Address <span class="required">*</span></label>
                               <input type="text" placeholder="Street address">
                            </div>
                         </div>
                         <div class="col-md-12">
                            <div class="checkout-form-list">
                               <input type="text" placeholder="Apartment, suite, unit etc. (optional)">
                            </div>
                         </div>
                         <div class="col-md-12">
                            <div class="checkout-form-list">
                               <label>Town / City <span class="required">*</span></label>
                               <input type="text" placeholder="Town / City">
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="checkout-form-list">
                               <label>State / County <span class="required">*</span></label>
                               <input type="text" placeholder="">
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="checkout-form-list">
                               <label>Postcode / Zip <span class="required">*</span></label>
                               <input type="text" placeholder="Postcode / Zip">
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="checkout-form-list">
                               <label>Email Address <span class="required">*</span></label>
                               <input type="email" placeholder="">
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="checkout-form-list">
                               <label>Phone <span class="required">*</span></label>
                               <input type="text" placeholder="Postcode / Zip">
                            </div>
                         </div>
                         <div class="col-md-12">
                            <div class="checkout-form-list create-acc d-flex align-content-center">
                               <input class="e-check-input" id="xbox" type="checkbox">
                               <label class="mb-0">Create an account?</label>
                            </div>
                            <div id="cbox_info" class="checkout-form-list create-account">
                               <p>Create an account by entering the information below. If you are a
                                  returning
                                  customer please login at the top of the page.</p>
                               <label>Account password <span class="required">*</span></label>
                               <input type="password" placeholder="password">
                            </div>
                         </div>
                      </div>
                      <div class="different-address">
                         <div class="ship-different-title">
                            <label>Ship to a different address?</label>
                            <input class="e-check-input" id="ship-box" type="checkbox">
                         </div>
                         <div id="ship-box-info">
                            <div class="row">
                               <div class="col-md-12">
                                  <div class="country-select">
                                     <label>Country <span class="required">*</span></label>
                                     <select>
                                        <option value="volvo">Bangladesh</option>
                                        <option value="saab">Algeria</option>
                                        <option value="mercedes">Afghanistan</option>
                                        <option value="audi">Ghana</option>
                                        <option value="audi2">Albania</option>
                                        <option value="audi3">Bahrain</option>
                                        <option value="audi4">Colombia</option>
                                        <option value="audi5">Dominican Republic</option>
                                     </select>
                                  </div>
                               </div>
                               <div class="col-md-6">
                                  <div class="checkout-form-list">
                                     <label>First Name <span class="required">*</span></label>
                                     <input type="text" placeholder="">
                                  </div>
                               </div>
                               <div class="col-md-6">
                                  <div class="checkout-form-list">
                                     <label>Last Name <span class="required">*</span></label>
                                     <input type="text" placeholder="">
                                  </div>
                               </div>
                               <div class="col-md-12">
                                  <div class="checkout-form-list">
                                     <label>Company Name</label>
                                     <input type="text" placeholder="">
                                  </div>
                               </div>
                               <div class="col-md-12">
                                  <div class="checkout-form-list">
                                     <label>Address <span class="required">*</span></label>
                                     <input type="text" placeholder="Street address">
                                  </div>
                               </div>
                               <div class="col-md-12">
                                  <div class="checkout-form-list">
                                     <input type="text" placeholder="Apartment, suite, unit etc. (optional)">
                                  </div>
                               </div>
                               <div class="col-md-12">
                                  <div class="checkout-form-list">
                                     <label>Town / City <span class="required">*</span></label>
                                     <input type="text" placeholder="Town / City">
                                  </div>
                               </div>
                               <div class="col-md-6">
                                  <div class="checkout-form-list">
                                     <label>State / County <span class="required">*</span></label>
                                     <input type="text" placeholder="">
                                  </div>
                               </div>
                               <div class="col-md-6">
                                  <div class="checkout-form-list">
                                     <label>Postcode / Zip <span class="required">*</span></label>
                                     <input type="text" placeholder="Postcode / Zip">
                                  </div>
                               </div>
                               <div class="col-md-6">
                                  <div class="checkout-form-list">
                                     <label>Email Address <span class="required">*</span></label>
                                     <input type="email" placeholder="">
                                  </div>
                               </div>
                               <div class="col-md-6">
                                  <div class="checkout-form-list">
                                     <label>Phone <span class="required">*</span></label>
                                     <input type="text" placeholder="Postcode / Zip">
                                  </div>
                               </div>
                            </div>
                         </div>
                         <div class="order-notes">
                            <div class="checkout-form-list">
                               <label>Order Notes</label>
                               <textarea id="checkout-mess" cols="30" rows="10"
                                  placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
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
                               <tr class="cart_item">
                                  <td class="product-name">
                                     Organic Full Cream Milk<strong class="product-quantity"> × 1</strong>
                                  </td>
                                  <td class="product-total">
                                     <span class="amount">$24.00</span>
                                  </td>
                               </tr>
                               <tr class="cart_item">
                                  <td class="product-name">
                                     Organic Fresh Milk<strong class="product-quantity"> ×
                                        1</strong>
                                  </td>
                                  <td class="product-total">
                                     <span class="amount">$12.00</span>
                                  </td>
                               </tr>
                               <tr class="cart_item">
                                  <td class="product-name">
                                     Orange Milk Chocolate<strong class="product-quantity"> ×
                                        1</strong>
                                  </td>
                                  <td class="product-total">
                                     <span class="amount">$22.00</span>
                                  </td>
                               </tr>
                            </tbody>
                            <tfoot>
                               <tr class="cart-subtotal">
                                  <th>Cart Subtotal</th>
                                  <td><span class="amount">$58.00</span></td>
                               </tr>
                               <tr class="shipping">
                                  <th>Shipping</th>
                                  <td>
                                     <ul>
                                        <li>
                                           <input type="radio">
                                           <label>
                                              Flat Rate: <span class="amount">$7.00</span>
                                           </label>
                                        </li>
                                        <li>
                                           <input type="radio">
                                           <label>Free Shipping:</label>
                                        </li>
                                     </ul>
                                  </td>
                               </tr>
                               <tr class="order-total">
                                  <th>Order Total</th>
                                  <td><strong><span class="amount">$85.00</span></strong>
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