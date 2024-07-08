
<?php $__env->startSection('body'); ?>
<?php $__env->startPush('css'); ?>
<!-- CSS here -->
<link rel="stylesheet" href="<?php echo e(url('/product_page')); ?>/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo e(url('/product_page')); ?>/css/meanmenu.min.css">
<link rel="stylesheet" href="<?php echo e(url('/product_page')); ?>/css/animate.css">
<link rel="stylesheet" href="<?php echo e(url('/product_page')); ?>/css/swiper.min.css">
<link rel="stylesheet" href="<?php echo e(url('/product_page')); ?>/css/slick.css">
<link rel="stylesheet" href="<?php echo e(url('/product_page')); ?>/css/magnific-popup.css">
<link rel="stylesheet" href="<?php echo e(url('/product_page')); ?>/css/fontawesome-pro.css">
<link rel="stylesheet" href="<?php echo e(url('/product_page')); ?>/css/spacing.css">
<link rel="stylesheet" href="<?php echo e(url('/product_page')); ?>/css/main.css">
<style>
   main {
      margin-top: 100px;
   }
.theme-bg-3{
   background: #fca52a;
}
.fill-btn-hover{
   color:#ffffff;
}
.fill-btn{
background-color: black;
}
.fill-btn::before {
   background-color: #fca52a;
}
.breadcrumb__wrapper .nav_class {
    height: 40px;
    width: 350px;
    border: 1px solid;
    border-radius: 8px;
    text-align: center;
    padding: 10px;
    border-color: #FCA52A;
    background-color: rgba(252, 165, 42, 0.75); /* Set background opacity to 75% */
    color: white; /* Ensuring text color is white */
}

.breadcrumb__wrapper .nav_class:hover {
    border-color: #FCA52A; /* Keep the same border color or change it if needed */
    background-color: rgba(252, 165, 42, 1); /* Optionally, make the background fully opaque on hover */
   
}
.breadcrumb__wrapper .nav_class h6 {
    opacity: 1; /* Full opacity for the text */
}
.bd-basic__pagination ul li .current {
    
    background-color: #FCA52A;
    color: black;
    
}


   @media (max-width: 767px) {
      main {
      margin-top: 20px;
   }
   .navbar-toggler span + span {
    margin-top: 10px;
}
   
}
</style>
<?php $__env->stopPush(); ?>

<body>

   <!-- Back to top start -->
   <div class="backtotop-wrap cursor-pointer">
      <svg class="backtotop-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
         <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
      </svg>
   </div>
   <!-- Back to top end -->

   <!-- Body main wrapper start -->
   <main>

      <!-- Breadcrumb area start  -->
      <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
         <div class="breadcrumb__thumb" data-background="<?php echo e(url('/product_page')); ?>/imgs/bg/breadcrumb-bg.jpg"></div>
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-xxl-12">
                  <div class="breadcrumb__wrapper text-center">
                     <h4 class="breadcrumb__title">Welcome to the world of Forever Medspa.</h4>
                     <center><div class="nav_class">
                        <h6 style="color: white;opacity: 100%;">Avail these amazing Services Now!</h6>
                     </div>
                  </center>
                     <div class="breadcrumb__menu">
                        <nav>
                           <ul>
                              <li><span><a href="index.html">Home</a></span></li>
                              <li><span>Services</span></li>
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Breadcrumb area start  -->

      <!-- Postbox details area start -->
      <section class="postbox__area grey-bg-4 section-space">
         <div class="container">
            <div class="row gy-50">
               <div class="col-xxl-8 col-lg-8">
                  <div class="postbox__wrapper">
                     <?php if(isset($data) && $data['status']!=404): ?>
                     <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                     <article class="postbox__item mb-50 transition-3">
                        <div class="postbox__thumb w-img mb-30">
                           <a href="blog-details.html">
                              <img src="<?php echo e($value['product_image']); ?>" alt="">
                           </a>
                        </div>
                        <div class="postbox__content">
                           <div class="postbox__meta">
                              <span>
                                 <a href="#">
                                    <svg width="13" height="14" viewBox="0 0 13 14" fill="none"
                                       xmlns="http://www.w3.org/2000/svg">
                                       <path
                                          d="M11.6667 13V11.6667C11.6667 10.9594 11.3857 10.2811 10.8856 9.78105C10.3855 9.28095 9.70724 9 9 9H3.66667C2.95942 9 2.28115 9.28095 1.78105 9.78105C1.28095 10.2811 1 10.9594 1 11.6667V13"
                                          stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                          stroke-linejoin="round" />
                                       <path
                                          d="M6.33317 6.33333C7.80593 6.33333 8.99984 5.13943 8.99984 3.66667C8.99984 2.19391 7.80593 1 6.33317 1C4.86041 1 3.6665 2.19391 3.6665 3.66667C3.6665 5.13943 4.86041 6.33333 6.33317 6.33333Z"
                                          stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                          stroke-linejoin="round" />
                                    </svg>
                                    By Alex Manie
                                 </a>
                              </span>
                              <span>
                                 <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                       d="M7.5 14C11.0899 14 14 11.0899 14 7.5C14 3.91015 11.0899 1 7.5 1C3.91015 1 1 3.91015 1 7.5C1 11.0899 3.91015 14 7.5 14Z"
                                       stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                       stroke-linejoin="round" />
                                    <path d="M7.5 3.59961V7.49961L10.1 8.79961" stroke="currentColor" stroke-width="1.5"
                                       stroke-linecap="round" stroke-linejoin="round" />
                                 </svg> January 22, 2022
                              </span>
                              <span>
                                 <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                       d="M12.9718 6.66668C12.9741 7.54659 12.769 8.4146 12.3732 9.20001C11.9039 10.1412 11.1825 10.9328 10.2897 11.4862C9.39697 12.0396 8.36813 12.3329 7.31844 12.3333C6.4406 12.3356 5.57463 12.13 4.79106 11.7333L1 13L2.26369 9.20001C1.86791 8.4146 1.66281 7.54659 1.6651 6.66668C1.66551 5.61452 1.95815 4.58325 2.51025 3.68838C3.06236 2.79352 3.85211 2.0704 4.79106 1.60002C5.57463 1.20331 6.4406 0.997725 7.31844 1.00002H7.65099C9.03729 1.07668 10.3467 1.66319 11.3284 2.64726C12.3102 3.63132 12.8953 4.94378 12.9718 6.33334V6.66668Z"
                                       stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                       stroke-linejoin="round" />
                                 </svg>35
                              </span>
                           </div>
                           <h3 class="postbox__title">
                              <a href="blog-details.html"><?php echo e($value['product_name']); ?></a>
                           </h3>
                           <div class="postbox__text">
                              <p><?php echo $value['product_description']; ?></p>
                           </div>
                           <div class="postbox__read-more">
                              <a class="text-btn" href="#">Explore Now<span><i
                                       class="fa-regular fa-angle-right"></i></span></a>
                           </div>
                        </div>
                     </article>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     <?php else: ?>
                        <p><?php echo e($data['error']); ?></p>
                     <?php endif; ?>
                     
                     
                 
                     
                     <div class="pagination__wrapper">
                        <div class="bd-basic__pagination d-flex align-items-center justify-content-center">
                           <nav>
                              
                              <?php echo e($data->links('vendor.pagination.custom')); ?>

                           </nav>
                        </div>
                     </div>
                     
                  </div>
               </div>
               <div class="col-xxl-4 col-lg-4">
                  <div class="sidebar__wrapper bd-sticky pl-30">
                     <div class="sidebar__widget mb-20">
                        <div class="sidebar__widget-content">
                           <div class="sidebar__search">
                              <form action="#">
                                 <div class="sidebar__search-input">
                                    <input type="text" placeholder="Enter your keywords...">
                                    <button type="submit">
                                       <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                          xmlns="http://www.w3.org/2000/svg">
                                          <path
                                             d="M9.55 18.1C14.272 18.1 18.1 14.272 18.1 9.55C18.1 4.82797 14.272 1 9.55 1C4.82797 1 1 4.82797 1 9.55C1 14.272 4.82797 18.1 9.55 18.1Z"
                                             stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                             stroke-linejoin="round" />
                                          <path d="M19.0002 19.0002L17.2002 17.2002" stroke="currentColor"
                                             stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                       </svg>
                                    </button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                     <div class="sidebar__widget mb-45">
                        <div class="sidebar__widget-content">
                           <div class="sidebar__author">
                              <div class="sidebar__author-thumb">
                                 <img src="<?php echo e(url('/product_page')); ?>/imgs/blog/blog-10.jpg" alt="">
                              </div>
                              <div class="sidebar__author-content">
                                 <h3 class="sidebar__author-title">Colene Landin</h3>
                                 <p>Adipiscing elit, sed do eiu tempor incididunt ut labore et dolore magna aliqua. Ut
                                    enim ad minim </p>
                                 <div
                                    class="sidebar__author-social d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="sidebar__widget mb-45">
                        <h3 class="sidebar__widget-title">Category</h3>
                        <div class="sidebar__widget-content">
                           <ul>
                              <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <li><a href="blog.html"><?php echo e(substr(ucFirst($value->cat_name),0,20)); ?> <span>
                              <?php
                                 $count= \App\Models\Product::where('cat_id',$value->id)->count();
                              ?> 
                              <?php echo e($count); ?>  
                              </span></a></li>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              
                           </ul>
                        </div>
                     </div>
                     <div class="sidebar__widget mb-45">
                        <h3 class="sidebar__widget-title">Popular Services</h3>
                        <div class="sidebar__widget-content">
                           <div class="sidebar__post">
                              <div class="rc__post d-flex align-items-center">
                                 <div class="rc__post-thumb">
                                    <a href="blog-details.html"><img src="<?php echo e(url('/product_page')); ?>/imgs/blog/blog-11.jpg" alt=""></a>
                                 </div>
                                 <div class="rc__post-content">
                                    <h4 class="rc__post-title">
                                       <a href="blog-details.html">Business meeting 2021 in San Francisco</a>
                                    </h4>
                                    <div class="rc__meta">
                                       <span>
                                          <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                             <path
                                                d="M7.5 14C11.0899 14 14 11.0899 14 7.5C14 3.91015 11.0899 1 7.5 1C3.91015 1 1 3.91015 1 7.5C1 11.0899 3.91015 14 7.5 14Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                             <path d="M7.5 3.59961V7.49961L10.1 8.79961" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                          </svg>July 21, 2022
                                       </span>
                                    </div>
                                 </div>
                              </div>
                              <div class="rc__post d-flex align-items-center">
                                 <div class="rc__post-thumb">
                                    <a href="blog-details.html"><img src="<?php echo e(url('/product_page')); ?>/imgs/blog/blog-12.jpg" alt=""></a>
                                 </div>
                                 <div class="rc__post-content">
                                    <h4 class="rc__post-title">
                                       <a href="blog-details.html">Developing privacy user-centric apps</a>
                                    </h4>
                                    <div class="rc__meta">
                                       <span>
                                          <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                             <path
                                                d="M7.5 14C11.0899 14 14 11.0899 14 7.5C14 3.91015 11.0899 1 7.5 1C3.91015 1 1 3.91015 1 7.5C1 11.0899 3.91015 14 7.5 14Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                             <path d="M7.5 3.59961V7.49961L10.1 8.79961" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                          </svg>July 21, 2022
                                       </span>
                                    </div>
                                 </div>
                              </div>
                              <div class="rc__post d-flex align-items-center">
                                 <div class="rc__post-thumb">
                                    <a href="blog-details.html"><img src="<?php echo e(url('/product_page')); ?>/imgs/blog/blog-13.jpg" alt=""></a>
                                 </div>
                                 <div class="rc__post-content">
                                    <h4 class="rc__post-title">
                                       <a href="blog-details.html">Starting and Growing Web Design in 2022</a>
                                    </h4>
                                    <div class="rc__meta">
                                       <span>
                                          <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                             <path
                                                d="M7.5 14C11.0899 14 14 11.0899 14 7.5C14 3.91015 11.0899 1 7.5 1C3.91015 1 1 3.91015 1 7.5C1 11.0899 3.91015 14 7.5 14Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                             <path d="M7.5 3.59961V7.49961L10.1 8.79961" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                          </svg>July 21, 2022
                                       </span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- Postbox details area end -->

      <!-- Newsletter area start -->
      <section class="newsletter-area p-relative">
         <div class="newsletter-overlay theme-bg-3 "></div>
         <div class="container">
            <div class="newsletter-grid p-relative">
               <div class="intro-bg">
                  <div class="intro-bg-thumb include-bg" data-background="<?php echo e(url('/product_page')); ?>/imgs/bg/intro-bg.png"></div>
               </div>
               <div class="row gy-4 align-items-center">
                  <div class="col-xxl-6 col-xl-6 col-lg-6">
                     <div class="newsletter-content">
                        <h3 class="newsletter-title">Buy Our Awesome Giftcards</h3>
                     </div>
                  </div>
                  <div class="col-xxl-6 col-xl-6 col-lg-6">
                     <div class="newsletter-form">
                        <form action="#">
                           <div class="newsletter-input p-relative">
                             
                              <button class="fill-btn" type="submit">
                                
                                 <span class="fill-btn-inner">
                                   Buy Now
                                    <span class="fill-btn-hover"> Buy Now</span>
                                 </span>
                              </button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- Newsletter area end -->

   </main>
   <!-- Body main wrapper end -->


   <!-- JS here -->
   <script src="<?php echo e(url('/product_page')); ?>/js/jquery-3.6.0.min.js"></script>
   <script src="<?php echo e(url('/product_page')); ?>/js/waypoints.min.js"></script>
   <script src="<?php echo e(url('/product_page')); ?>/js/bootstrap.bundle.min.js"></script>
   <script src="<?php echo e(url('/product_page')); ?>/js/meanmenu.min.js"></script>
   <script src="<?php echo e(url('/product_page')); ?>/js/swiper.min.js"></script>
   <script src="<?php echo e(url('/product_page')); ?>/js/slick.min.js"></script>
   <script src="<?php echo e(url('/product_page')); ?>/js/magnific-popup.min.js"></script>
   <script src="<?php echo e(url('/product_page')); ?>/js/counterup.js"></script>
   <script src="<?php echo e(url('/product_page')); ?>/js/wow.js"></script>
   <script src="<?php echo e(url('/product_page')); ?>/js/ajax-form.js"></script>
   <script src="<?php echo e(url('/product_page')); ?>/js/beforeafter.jquery-1.0.0.min.js"></script>
   <script src="<?php echo e(url('/product_page')); ?>/js/main.js"></script>
</body>

</html>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('footerscript'); ?>
<script src="<?php echo e(url('/')); ?>/giftcards/js/custom.js"></script>
<script src="<?php echo e(url('/')); ?>/giftcards/js/giftcard.js"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.front-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\MedsapGiftCardNew\resources\views/product/index.blade.php ENDPATH**/ ?>