
<?php $__env->startSection('body'); ?>
<!-- Body main wrapper start -->
<main>

    <!-- Breadcrumb area start  -->
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
       <div class="breadcrumb__thumb" data-background="<?php echo e(url('/product_page')); ?>/imgs/bg/breadcrumb-bg.jpg"></div>
       <div class="container">
          <div class="row justify-content-center">
             <div class="col-xxl-12">
                <div class="breadcrumb__wrapper text-center">
                   <h2 class="breadcrumb__title">Cart</h2>
                   <div class="breadcrumb__menu">
                      <nav>
                         <ul>
                            <li><span><a href="index.html">Home</a></span></li>
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
                            <th class="product-price">Unit Price</th>
                            <th class="product-quantity">Quantity</th>
                            <th class="product-subtotal">Total</th>
                            <th class="product-remove">Remove</th>
                         </tr>
                      </thead>
                      <tbody>
                         <tr>
                            <td class="product-thumbnail"><a href="product-details.html"><img
                                     src="<?php echo e(url('/product_page')); ?>/imgs/product/details/details-01.png" alt="img"></a></td>
                            <td class="product-name"><a href="product-details.html">Organic Full Cream Milk</a></td>
                            <td class="product-price"><span class="amount">$24.00</span></td>
                            <td class="product-quantity text-center">
                               <div class="product-quantity mt-10 mb-10">
                                  <div class="product-quantity-form">
                                     <form action="#">
                                        <button class="cart-minus"><i class="far fa-minus"></i></button>
                                        <input class="cart-input" type="text" value="1">
                                        <button class="cart-plus"><i class="far fa-plus"></i></button>
                                     </form>
                                  </div>
                               </div>
                            </td>
                            <td class="product-subtotal"><span class="amount">$24.00</span></td>
                            <td class="product-remove"><a href="#"><i class="fa fa-times"></i></a></td>
                         </tr>
                         <tr>
                            <td class="product-thumbnail"><a href="product-details.html"><img
                                     src="<?php echo e(url('/product_page')); ?>/imgs/product/details/details-02.png" alt="img"></a></td>
                            <td class="product-name"><a href="product-details.html">Organic Fresh Milk</a>
                            </td>
                            <td class="product-price"><span class="amount">$12.00</span></td>
                            <td class="product-quantity text-center">
                               <div class="product-quantity mt-10 mb-10">
                                  <div class="product-quantity-form">
                                     <form action="#">
                                        <button class="cart-minus"><i class="far fa-minus"></i></button>
                                        <input class="cart-input" type="text" value="1">
                                        <button class="cart-plus"><i class="far fa-plus"></i></button>
                                     </form>
                                  </div>
                               </div>
                            </td>
                            <td class="product-subtotal"><span class="amount">$12.00</span></td>
                            <td class="product-remove"><a href="#"><i class="fa fa-times"></i></a></td>
                         </tr>
                         <tr>
                            <td class="product-thumbnail"><a href="product-details.html"><img
                                     src="<?php echo e(url('/product_page')); ?>/imgs/product/details/details-03.png" alt="img"></a></td>
                            <td class="product-name"><a href="product-details.html">Orange Milk Chocolate</a></td>
                            <td class="product-price"><span class="amount">$42.00</span></td>
                            <td class="product-quantity text-center">
                               <div class="product-quantity mt-10 mb-10">
                                  <div class="product-quantity-form">
                                     <form action="#">
                                        <button class="cart-minus"><i class="far fa-minus"></i></button>
                                        <input class="cart-input" type="text" value="1">
                                        <button class="cart-plus"><i class="far fa-plus"></i></button>
                                     </form>
                                  </div>
                               </div>
                            </td>
                            <td class="product-subtotal"><span class="amount">$42.00</span></td>
                            <td class="product-remove"><a href="#"><i class="fa fa-times"></i></a></td>
                         </tr>
                      </tbody>
                   </table>
                </div>
                <div class="row">
                   <div class="col-12">
                      <div class="coupon-all">
                         <div class="coupon d-flex align-items-center">
                            <input id="coupon_code" class="input-text" name="coupon_code" placeholder="Coupon code"
                               type="text">
                            <button onclick="window.location.reload()" class="fill-btn" type="submit">
                               <span class="fill-btn-inner">
                                  <span class="fill-btn-normal">apply coupon</span>
                                  <span class="fill-btn-hover">apply coupon</span>
                               </span>
                            </button>
                         </div>
                         <div class="coupon2">
                            <button onclick="window.location.reload()" class="fill-btn" type="submit">
                               <span class="fill-btn-inner">
                                  <span class="fill-btn-normal">Update cart</span>
                                  <span class="fill-btn-hover">Update cart</span>
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
                            <li>Subtotal <span>$78.00</span></li>
                            <li>Total <span>$78.00</span></li>
                         </ul>
                         <a class="fill-btn" href="checkout.html">
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

 </main>
 <!-- Body main wrapper end -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front_product', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\MedsapGiftCardNew\resources\views/product/cart.blade.php ENDPATH**/ ?>