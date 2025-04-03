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
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>

    .tran{
    
    padding-top: 200px;
    }
            /* Define styles for the print version */
            @media print {
                body * {
                    visibility: hidden;
                }
    
                #printableContent,
                #printableContent * {
                    visibility: visible;
                }
    
                #printableContent {
                    position: absolute;
                    left: 0;
                    top: 0;
                }
            }
    
            .fit-image {
                max-width: 50%;
                height: auto;
            }
    
            .payment-image {
                max-width: 20%;
                height: auto;
                align-items: center;
            }
    
            .form-card {
        text-align: center;
        margin: 20px auto;
        width: 80%;
        max-width: 400px; /* Adjust max-width as needed */
        padding: 80px 20px; /* Adjust padding to fit content within the image */
        background-color: #ffffff; /* Background color for the container */
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Box shadow for a subtle effect */
        background-image: url({{ asset('giftcards/images/failed.png') }});
        background-size: 400px; /* Cover the entire container */
        background-repeat: no-repeat; /* Set the background to appear only once */
    }
    
    
    .tran{
    
    padding-top: 200px;
    }
    
    .col-7{
    padding-left: 0px;
    padding-right: 0px;
    
    }
    
    .row{
    
    margin-left: -60px;
    margin-right: -60px;
    }
    
    /* Adjust other styles as needed */
    
    @media screen and (max-width: 768px){
    
        .form-card {
        text-align: center;
        margin-bottom: 50px;
        width: 80%;
        max-width: 400px; /* Adjust max-width as needed */
        padding: 60px 20px; /* Adjust padding to fit content within the image */
        background-color: #ffffff; /* Background color for the container */
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Box shadow for a subtle effect */
        background-image: url({{asset('giftcards/images/failed.png')}});
        background-size: 350px; /* Cover the entire container */
        background-repeat: no-repeat; /* Set the background to appear only once */
    }
    
    }
    
        </style>
</head>
<body id="home" data-spy="scroll" data-target="#navbar-wd" data-offset="98">
    
       <!-- END LOADER -->
	
	<!-- Start header -->
	<header class="top-header">
		<nav class="navbar header-nav navbar-expand-lg">
            <div class="container">
				<a class="navbar-brand" href="{{url('/')}}"><img src="{{url('/images/gifts/logo.png')}}" alt="image" style="height:70px;" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';"></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-wd" aria-controls="navbar-wd" aria-expanded="false" aria-label="Toggle navigation">
					<span></span>
					<span></span>
					<span></span>
				</button>
                <div class="collapse navbar-collapse justify-content-end" id="navbar-wd">
                    <ul class="navbar-nav">
                         <li><a class="nav-link active" href="{{url('/')}}">Home</a></li> 
                        <li><a class="nav-link" href="https://forevermedspanj.com/">Forever Medspa</a></li>
                        <li>
                            <a class="nav-link {{ Request::is('services') ? 'active' : '' }}" href="{{ route('services') }}">
                                Black Friday Deals
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </nav>
	</header>
	<!-- End header -->
	
	<!-- Start Banner -->
	<div id="myDiv" class="about-box" style="padding-bottom: 0;">
        <fieldset id="finishbox">
            <div class="form-card">
                <img id="logosuccess" src="{{url('/images/gifts/logo.png')}}" style="width:200px; height:100px; display:none">
                <div class="row justify-content-center">
                    <div class="col-7 ">
                    <h4 class="tran">The Payment has failed.</h4>
                        <p> <b>Please consult the Medspa Welness Centre in the given email address: admin@forevermedspanj.com</b></p>
                       
                       
                    </div>
                </div>
                
            </div>
        </fieldset>
    </div>
    {{--  for Redeem Process  --}}
    <div class="container">
        <h3>Redeem Process</h3>
        <ol>
           <li>The customer needs to purchase the giftcard from<strong> https://myforevermedspa.com</strong></li>
           <li>After Purchasing the giftcard, the customer needs to visit the <strong>MedSpa Wellness Center</strong> to redeem the dedicated purchased Giftcard</li>
           <li>Admins at the Welness centre will check the details of the giftcard and process the transaction as per need of the customer</li>
        </ol>
     </div>


    <center class="mb-2">
        <a href="{{ url('/') }}"  class="btn btn-primary mr-2">Home</a>
        {{-- <button  class="btn btn-block btn-outline-success" id="printButton" onclick="printDiv()">Print</button> --}}
    </center>
	
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
<script>
    function printDiv() {
        $('#logosuccess').css('display', 'block');
        var divToPrint = document.getElementById('myDiv');
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><head><title>Print</title></head><body>' + divToPrint.innerHTML + '</body></html>');
        newWin.document.close();
        $('#logosuccess').css('display', 'none');
        newWin.print();
    }
</script>
</body>
</html>

