<!DOCTYPE html>
<html lang="en"><!-- Basic -->
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
   
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
 
     <!-- Site Metas -->
    <title>@yield('title','Medspa')</title>  
    <meta name="keywords" content="@yield('keywords','Medspa')">
    <meta name="description" content="@yield('description','Medspa')">
    <meta name="Deepak Prasad" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="{{url('/medspa.png')}}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{url('/medspa.png')}}" />

       {{-- Main Page Css --}}
   <link rel="stylesheet" href="{{url('/')}}/giftcards/css/style.css"> 
       <!-- CSS here -->
   <link rel="stylesheet" href="{{url('/product_page')}}/css/bootstrap.min.css">
   <link rel="stylesheet" href="{{url('/product_page')}}/css/meanmenu.min.css">
   <link rel="stylesheet" href="{{url('/product_page')}}/css/animate.css">
   <link rel="stylesheet" href="{{url('/product_page')}}/css/swiper.min.css">
   <link rel="stylesheet" href="{{url('/product_page')}}/css/slick.css">
   <link rel="stylesheet" href="{{url('/product_page')}}/css/magnific-popup.css">
   <link rel="stylesheet" href="{{url('/product_page')}}/css/fontawesome-pro.css">
   <link rel="stylesheet" href="{{url('/product_page')}}/css/spacing.css">
   <link rel="stylesheet" href="{{url('/product_page')}}/css/main.css">

     <style>

         @stack('css');
     </style>
<meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body>
 
    <!-- preloader start -->
    <div id="preloader">
       <div class="bd-loader-inner">
          <div class="bd-loader">
             {{-- <span class="bd-loader-item"></span>
             <span class="bd-loader-item"></span>
             <span class="bd-loader-item"></span>
             <span class="bd-loader-item"></span>
             <span class="bd-loader-item"></span>
             <span class="bd-loader-item"></span>
             <span class="bd-loader-item"></span>
             <span class="bd-loader-item"></span> --}}
             <img src="{{url('/uploads/FOREVER-MEDSPA/medspa_logo.gif')}}" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
          </div>
       </div>
    </div>

    <!-- END LOADER -->
	
	<!-- Start header -->
	<header class="top-header">
		<nav class="navbar header-nav navbar-expand-lg">
            <div class="container">
				<a class="navbar-brand" href="{{url('/')}}"><img src="https://forevermedspanj.com/wp-content/uploads/forever-color.fw_.png" alt="image" style="height:81px;" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-wd" aria-controls="navbar-wd" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbar-wd">
                    <ul class="navbar-nav">
                         <li><a class="nav-link" href="{{url('/')}}">Giftcards</a></li> 
                        <li><a class="nav-link" href="https://forevermedspanj.com/" target="_blank">Forever Medspa</a></li>
						<li>
                            {{-- <a class="nav-link {{ Request::is('services') ? 'active' : '' }}" href="{{ route('services') }}">
                                Black Friday Deals
                            </a> --}}
                            {{-- <a class="nav-link {{ Request::is('category/FOREVER-MEDSPA') ? 'active' : '' }}" href="{{ route('category', ['token' => 'FOREVER-MEDSPA']) }}">
                                Services
                            </a> --}}
                        </li>
                        {{-- Cart Code --}}
                        @php
                        $cart = session()->get('cart', []);
                        $amount=0;
                        
                        @endphp
                        @if(count(session()->get('cart', []))>0)
                        <div id="cart" class="btn-group btn-block">
                            <button onclick="window.location.href='{{route('cartview')}}'" type="button" data-toggle="dropdown" data-loading-text="Loading..." class="btn btn-inverse btn-block btn-lg dropdown-toggle"><i class="fa fa-shopping-bag"></i> <span id="cart-total" class="hidden-xs">{{ count(session()->get('cart', [])) ? count(session()->get('cart', [])) : 0 }}
                            </span></button>
                            {{-- <ul class="dropdown-menu pull-right">    <li>
                                <p class="text-center">Your shopping cart is empty!</p>
                              </li>  </ul> --}}
                        </div>
                        @endif
                       
                        {{-- Cart Code END --}}
                        
                    </ul>
                </div>
            </div>
        </nav>
	</header>
	<!-- End header -->
	
	<!-- Start Banner -->
	@yield('body')
	
	<!-- End Subscribe -->
	
	<!-- Start Footer -->
	<footer class="footer-box">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<p class="footer-company-name">All Rights Reserved. &copy; {{date('Y')}} <a href="#">FOREVER MEDSPA</a> Design By : <a href="https://www.thetemz.com/">TEMZ Solution Pvt.Ltd</a></p>
				</div>
			</div>
		</div>
	</footer>
	<!-- End Footer -->
	
	<a href="#" id="scroll-to-top" class="hvr-radial-out"><i class="fa fa-angle-up"></i></a>

	<!-- ALL JS FILES -->
    <script src="{{url('/product_page')}}/js/jquery-3.6.0.min.js"></script>
    <script src="{{url('/product_page')}}/js/waypoints.min.js"></script>
    <script src="{{url('/product_page')}}/js/bootstrap.bundle.min.js"></script>
    <script src="{{url('/product_page')}}/js/meanmenu.min.js"></script>
    <script src="{{url('/product_page')}}/js/swiper.min.js"></script>
    <script src="{{url('/product_page')}}/js/slick.min.js"></script>
    <script src="{{url('/product_page')}}/js/magnific-popup.min.js"></script>
    <script src="{{url('/product_page')}}/js/counterup.js"></script>
    <script src="{{url('/product_page')}}/js/wow.js"></script>
    <script src="{{url('/product_page')}}/js/ajax-form.js"></script>
    <script src="{{url('/product_page')}}/js/beforeafter.jquery-1.0.0.min.js"></script>
    <script src="{{url('/product_page')}}/js/main.js"></script>
    <script src="{{url('/')}}/giftcards/js/custom.js"></script>
    

@stack('footerscript')
</body>
</html>