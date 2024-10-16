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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{url('/')}}/giftcards/css/bootstrap.min.css">
    <!-- Pogo Slider CSS -->
    <link rel="stylesheet" href="{{url('/')}}/giftcards/css/pogo-slider.min.css">
	<!-- Site CSS -->
    <link rel="stylesheet" href="{{url('/')}}/giftcards/css/style.css">    
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{url('/')}}/giftcards/css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{url('/')}}/giftcards/css/custom.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="shortcut icon" type="image/x-icon" href="{{url('/medspa.png')}}">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    @stack('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
@media (max-width: 767px) {
 .navbar-brand img {
  width: 180px;
  margin-left: 25px;
}
}

</style>

</head>
<body id="home" data-spy="scroll" data-target="#navbar-wd" data-offset="98">
    
    <!-- LOADER -->
    <div id="preloader">
        <div class="loader">
            <div class="box"></div>
            <div class="box"></div>
        </div>
    </div><!-- end loader -->


    <!-- END LOADER -->
	
	<!-- Start header -->
	<header class="top-header">
		<nav class="navbar header-nav navbar-expand-lg">
            <div class="container">
				<a class="navbar-brand" href="{{url('/')}}"><img src="https://forevermedspanj.com/wp-content/uploads/forever-color.fw_.png" alt="image" style="height:81px;"></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-wd" aria-controls="navbar-wd" aria-expanded="false" aria-label="Toggle navigation">
					<span></span>
					<span></span>
					<span></span>
				</button>
                <div class="collapse navbar-collapse justify-content-end" id="navbar-wd">
                    <ul class="navbar-nav">
                         <li><a class="nav-link active" href="{{url('/')}}">Giftcards</a></li> 
                        <li><a class="nav-link" href="https://forevermedspanj.com/" target="_blank">Forever Medspa</a></li>
						<li>
                            <a class="nav-link {{ Request::is('category/FOREVER-MEDSPA') ? 'active' : '' }}" href="{{ route('category', ['token' => 'FOREVER-MEDSPA']) }}">
                                Services
                            </a>
                        </li>
                        
                        <a class="nav-link {{ Request::is('patient-referral') ? 'active' : '' }}" href="{{ route('patient-referral') }}">
                            Referral
                        </a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="{{url('/')}}/giftcards/js/bootstrap.min.js"></script>
    <!-- ALL PLUGINS -->
 <!--   <script src="{{url('/')}}/giftcards/js/jquery.pogo-slider.min.js"></script> -->
	<!--<script src="{{url('/')}}/giftcards/js/slider-index.js"></script>-->
    <script src="{{url('/')}}/giftcards/js/custom.js"></script>

@stack('footerscript')
</body>
</html>