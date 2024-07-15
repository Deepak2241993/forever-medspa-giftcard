<!DOCTYPE html>
<html lang="en"><!-- Basic -->
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
   
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
 
     <!-- Site Metas -->
    <title><?php echo $__env->yieldContent('title','Medspa'); ?></title>  
    <meta name="keywords" content="<?php echo $__env->yieldContent('keywords','Medspa'); ?>">
    <meta name="description" content="<?php echo $__env->yieldContent('description','Medspa'); ?>">
    <meta name="Deepak Prasad" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="<?php echo e(url('/medspa.png')); ?>" type="image/x-icon" />
    <link rel="apple-touch-icon" href="<?php echo e(url('/medspa.png')); ?>" />

       
   <link rel="stylesheet" href="<?php echo e(url('/')); ?>/giftcards/css/style.css"> 
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

     
    <?php echo $__env->yieldPushContent('css'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">


</head>

<body>
 
    <!-- preloader start -->
    <div id="preloader">
       <div class="bd-loader-inner">
          <div class="bd-loader">
             <span class="bd-loader-item"></span>
             <span class="bd-loader-item"></span>
             <span class="bd-loader-item"></span>
             <span class="bd-loader-item"></span>
             <span class="bd-loader-item"></span>
             <span class="bd-loader-item"></span>
             <span class="bd-loader-item"></span>
             <span class="bd-loader-item"></span>
          </div>
       </div>
    </div>

    <!-- END LOADER -->
	
	<!-- Start header -->
	<header class="top-header">
		<nav class="navbar header-nav navbar-expand-lg">
            <div class="container">
				<a class="navbar-brand" href="<?php echo e(url('/')); ?>"><img src="https://forevermedspanj.com/wp-content/uploads/forever-color.fw_.png" alt="image" style="height:81px;"></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-wd" aria-controls="navbar-wd" aria-expanded="false" aria-label="Toggle navigation">
					<span></span>
					<span></span>
					<span></span>
				</button>
                <div class="collapse navbar-collapse justify-content-end" id="navbar-wd">
                    <ul class="navbar-nav">
                         <li><a class="nav-link <?php if(Route::currentRouteName()==url('/')): ?><?php echo e('active'); ?> <?php endif; ?>" href="<?php echo e(url('/')); ?>">Giftcards</a></li> 
                        <li><a class="nav-link" href="https://forevermedspanj.com/" target="_blank">Forever Medspa</a></li>
						<li><a class="nav-link <?php if(Route::currentRouteName()!=url('/')): ?><?php echo e('active'); ?> <?php endif; ?>" href="<?php echo e(route('category',['token'=>'FOREVER-MEDSPA'])); ?>">Services</a></li>
                        
                    </ul>
                </div>
            </div>
        </nav>
	</header>
	<!-- End header -->
	
	<!-- Start Banner -->
	<?php echo $__env->yieldContent('body'); ?>
	
	<!-- End Subscribe -->
	
	<!-- Start Footer -->
	<footer class="footer-box">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<p class="footer-company-name">All Rights Reserved. &copy; <?php echo e(date('Y')); ?> <a href="#">FOREVER MEDSPA</a> Design By : <a href="https://www.thetemz.com/">TEMZ Solution Pvt.Ltd</a></p>
				</div>
			</div>
		</div>
	</footer>
	<!-- End Footer -->
	
	<a href="#" id="scroll-to-top" class="hvr-radial-out"><i class="fa fa-angle-up"></i></a>

	<!-- ALL JS FILES -->
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
    <script src="<?php echo e(url('/')); ?>/giftcards/js/custom.js"></script>
    

<?php echo $__env->yieldPushContent('footerscript'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\MedsapGiftCardNew\resources\views/layouts/front_product.blade.php ENDPATH**/ ?>