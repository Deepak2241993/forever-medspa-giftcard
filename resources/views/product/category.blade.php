
@extends('layouts.front_product')
@section('body')
@php
    use Carbon\Carbon;
@endphp
@push('css')
<!-- CSS here -->

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


input[type=text] {
    background-color: #ffffff;
    width: 100%;
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
{{-- Search box Style --}}
<style>
   * {
     box-sizing: border-box;
   }
   
   body {
     font: 16px Arial;  
   }
   
   /*the container must be positioned relative:*/
   .autocomplete {
     position: relative;
     display: inline-block;
   }
   
   input {
     border: 1px solid transparent;
     background-color: #f1f1f1;
     padding: 10px;
     font-size: 16px;
   }
   
   input[type=text] {
     background-color: #ffffff;
     width: 100%;
   }
   
   input[type=submit] {
     background-color: DodgerBlue;
     color: #fff;
     cursor: pointer;
   }
   
   .autocomplete-items {
     position: absolute;
     border: 1px solid #d4d4d4;
     border-bottom: none;
     border-top: none;
     z-index: 99;
     /*position the autocomplete items to be the same width as the container:*/
     top: 100%;
     left: 0;
     right: 0;
   }
   
   .autocomplete-items div {
     padding: 10px;
     cursor: pointer;
     background-color: #fff; 
     border-bottom: 1px solid #d4d4d4; 
   }
   
   /*when hovering an item:*/
   .autocomplete-items div:hover {
     background-color: #e9e9e9; 
   }
   
   /*when navigating through the items using the arrow keys:*/
   .autocomplete-active {
     background-color: DodgerBlue !important; 
     color: #ffffff; 
   }
   /* For Discount  */
   .hl05eU .Nx9bqj {
    display: inline-block;
    font-size: 16px;
    font-weight: 500;
    color: #212121;
}
.hl05eU .UkUFwK {
    color: #FCA52A;
    font-size: 16px;
    letter-spacing: -.2px;
    font-weight: 500;
}
.hl05eU .UkUFwK, .hl05eU .yRaY8j {
    display: inline-block;
    margin-left: 8px;
}

.nav {
    border-color: orange;
    --bs-nav-tabs-link-active-color: #fca52a;
    --bs-nav-tabs-link-active-border-color: #fca52a #fca52a #f6f6f6;
}

   </style>
@endpush

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
      {{-- <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
         <div class="breadcrumb__thumb" data-background="{{url('/uploads/FOREVER-MEDSPA')}}/med-spa-banner.jpg"></div>
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
                              <li><span><a href="{{url('/')}}">Home</a></span></li>
                              <li><span>Categories</span></li>
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div> --}}
      <div id="carouselExampleAutoplaying" class="carousel slide" style="margin-top: 80px" data-bs-ride="carousel">
         <div class="carousel-inner">
           <div class="carousel-item active">
             <img src="{{url('/images/Slide 1.jpg')}}" class="d-block w-100" alt="...">
           </div>
           <div class="carousel-item">
             <img src="{{url('/images/Slide 2.jpg')}}" class="d-block w-100" alt="...">
           </div>
           <div class="carousel-item">
             <img src="{{url('/images/Slide 3.jpg')}}" class="d-block w-100" alt="...">
           </div>
         </div>
         <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
           <span class="carousel-control-prev-icon" aria-hidden="true"></span>
           <span class="visually-hidden">Previous</span>
         </button>
         <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
           <span class="carousel-control-next-icon" aria-hidden="true"></span>
           <span class="visually-hidden">Next</span>
         </button>
       </div>

      
      <!-- Breadcrumb area start  -->

      <!-- Postbox details area start -->
      <section class="postbox__area grey-bg-4 section-space">
         <div class="container">
            <div class="row gy-50">
               <div class="col-xxl-8 col-lg-8">
                  <div class="postbox__wrapper">
                  
                     @if(isset($data))
                     @foreach($data as $value) 
                     @php
                     $id=$value->id;
                     $product = App\Models\Product::where('cat_id', 'LIKE', '%|' . $id . '|%')
                     ->where('cat_id', 'LIKE', '%|' . $id . '|%')
                     ->orWhere('cat_id', 'LIKE', $id . '|%')
                     ->orWhere('cat_id', 'LIKE', '%|' . $id)
                     ->orWhere('cat_id', $id)
                     ->where('status', 1)
                     ->where('product_is_deleted', 0)
                     ->first();

                  if(!empty($product))
                  {
                     $max_amount = App\Models\Product::where('cat_id', 'LIKE', '%|' . $id . '|%')
                     ->orWhere('cat_id', 'LIKE', $id . '|%')
                     ->orWhere('cat_id', 'LIKE', '%|' . $id)
                     ->orWhere('cat_id', $id)
                     ->max('discount_rate');

                     $min_amount = App\Models\Product::where('cat_id', 'LIKE', '%|' . $id . '|%')
                     ->orWhere('cat_id', 'LIKE', $id . '|%')
                     ->orWhere('cat_id', 'LIKE', '%|' . $id)
                     ->orWhere('cat_id', $id)
                     ->min('discount_rate');
                  }

                  
                     @endphp
                         @php
                        
                         $today = Carbon::now();
                         $dealEndDate = Carbon::parse($value['deal_end_date']);
                         $daysLeft = $dealEndDate->diffInDays($today, false); // 'false' allows for negative values if the date is in the past
                       @endphp
                     {{-- {{dd($product)}} --}}
                     @if($product && $daysLeft < 0 || $daysLeft == 0)
                     <article class="postbox__item mb-50 transition-3">
                        <div class="postbox__thumb w-img mb-30">
                           <a href="{{ route('product', ['slug' => $value['slug']]) }}">
                              <img src="{{$value['cat_image']}}" alt="{{$value['cat_name']}}">
                           </a>
                        </div>
                        <div class="postbox__content">
                          
                           <h3 class="postbox__title">
                              <a href="{{ route('product', ['slug' => $value['slug']]) }}">{{$value['cat_name']}}</a>
                          </h3>
                      
                      
                     
                       <div class="hl05eU">
                           <div class="UkUFwK">
                              <span><i><b>Up to {{$max_amount}}%  off</b></i></span>
                           {{-- For Countdown Code --}}
                           @if($daysLeft < 0)
                        </br><span><i>
                           <b> {{ str_replace('-','', $daysLeft) }} days left</b>
                           {{-- <b> {{ $daysLeft }} days left</b> --}}
                         </i></span>

                           @elseif ($daysLeft == 0)
                        </br><span> <i><b>  Deal ends today. Time left: 
                           <span id="countdown" ></span></b></i></span>
                           @else
                           <p>Deal has ended.</p>
                           @endif
                           </div>
                           @if ($daysLeft == 0)
                           <script>
                              function updateCountdown() {
                                  var now = new Date().getTime();
                                  var endOfDay = new Date();
                                  endOfDay.setHours(23, 59, 59, 999); // Set to end of day
                                  var distance = endOfDay - now;
                        
                                  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        
                                  document.getElementById("countdown").innerHTML = hours + "h "
                                  + minutes + "m " + seconds + "s ";
                        
                                  if (distance < 0) {
                                      clearInterval(x);
                                      document.getElementById("countdown").innerHTML = "EXPIRED";
                                  }
                              }
                        
                              var x = setInterval(updateCountdown, 1000);
                              updateCountdown(); // initial call to display countdown immediately
                          </script>
                          @endif
                   <div class="postbox__text">
                    
                              <p>{!!$value['cat_description']!!}</p>
                           </div>
                           <div class="product__add-cart col-md-3">
                              <a href="{{ route('product', ['slug' => $value['slug']]) }}" class="fill-btn cart-btn">
                                 <span class="fill-btn-inner">
                                    <span class="fill-btn-normal">Explore</span>
                                    <span class="fill-btn-hover">Explore</span>
                                 </span>
                              </a>
                           </div>
                           {{-- <div class="postbox__read-more">
                              <a class="btn btn-primary" href="{{ route('product', ['slug' => $value['slug']]) }}">Explore</a>
                           </div> --}}
                        </div>
                     </article>
                     @endif
                     @endforeach
                     @else
                        <p>{{$data['error']}}</p>
                     @endif
                    
                 
                     
                     <div class="pagination__wrapper">
                        <div class="bd-basic__pagination d-flex align-items-center justify-content-center">
                           <nav>
               
                              {{$data->links('vendor.pagination.custom')}}
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
                              <form autocomplete="off" action="{{route('ServicesSearch')}}" method="post">
                                 @csrf
                                 <div class="sidebar__search-input">
                                    <input type="text" id="myInput"  placeholder="Enter your keywords..." name="search">
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
                     {{-- <div class="sidebar__widget mb-45">
                        <h3 class="sidebar__widget-title">Category</h3>
                        <div class="sidebar__widget-content">
                           <ul>
                              @foreach($category as $value)
                              <li><a href="{{ route('productCategory', ['id' => $value->id]) }}">{{substr(ucFirst($value->cat_name),0,20)}}</a></li>
                              @endforeach
                              
                           </ul>
                        </div>
                     </div> --}}
                     {{-- <div class="sidebar__widget mb-45">
                        <div class="sidebar__widget-content">
                           <div class="sidebar__author">
                              <div class="sidebar__author-thumb">
                                 <img src="{{url('/product_page')}}/imgs/blog/blog-10.jpg" alt="">
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
                     </div> --}}
                      {{-- Hot Deals --}}
                      {{-- <div class="sidebar__widget mb-45">
                        <h3 class="sidebar__widget-title">Our Popular Offers</h3>
                        <div class="sidebar__widget-content">
                           <div class="sidebar__post">
                              <div class="rc__post d-flex align-items-center">
                                 <div class="rc__post-thumb">
                                    <a href="{{route('popularDeals')}}"><img src="{{url('/product_page')}}/imgs/blog/blog-11.jpg" alt=""></a>
                                 </div>
                                 <div class="rc__post-content">
                                    <h4 class="rc__post-title">
                                       <a href="{{route('popularDeals')}}">Business meeting 2021 in San Francisco</a>
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
                                    <a href="{{route('popularDeals')}}"><img src="{{url('/product_page')}}/imgs/blog/blog-12.jpg" alt=""></a>
                                 </div>
                                 <div class="rc__post-content">
                                    <h4 class="rc__post-title">
                                       <a href="{{route('popularDeals')}}">Developing privacy user-centric apps</a>
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
                                    <a href="{{route('popularDeals')}}"><img src="{{url('/product_page')}}/imgs/blog/blog-13.jpg" alt=""></a>
                                 </div>
                                 <div class="rc__post-content">
                                    <h4 class="rc__post-title">
                                       <a href="{{route('popularDeals')}}">Starting and Growing Web Design in 2022</a>
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
                     </div> --}}
                     @if(count($popular_service)>0)
                     <div class="sidebar__widget mb-45">
                        <h3 class="sidebar__widget-title">Popular Services</h3>
                        <div class="sidebar__widget-content">
                           <div class="sidebar__post">
                             
                              @foreach($popular_service as $key=>$value)
                              @if($key<=9)
                              <div class="rc__post d-flex align-items-center">
                                 <div class="rc__post-thumb">
                                    <a href="{{ route('PopularService', ['id' => $value->id]) }}"><img src="{{$value->product_image}}" alt="{{$value->product_name}}"></a>
                                 </div>
                                 <div class="rc__post-content">
                                    <h4 class="rc__post-title">
                                       <a href="{{ route('PopularService', ['id' => $value->id]) }}">{{$value->product_name}}</a>
                                    </h4>
                                    {{-- <div class="rc__meta">
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
                                    </div> --}}
                                 </div>
                              </div>
                              @endif
                              @endforeach
                              
                              
                           </div>
                        </div>
                     </div>
                    @endif
                     
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
                  <div class="intro-bg-thumb include-bg" data-background="{{url('/product_page')}}/imgs/bg/intro-bg.png"></div>
               </div>
               <div class="row gy-4 align-items-center">
                  <div class="col-xxl-6 col-xl-6 col-lg-6">
                     <div class="newsletter-content">
                        <h3 class="newsletter-title">Buy Our Awesome Giftcards</h3>
                     </div>
                  </div>
                  <div class="col-xxl-6 col-xl-6 col-lg-6">
                     <div class="newsletter-form">
                       
                           <div class="newsletter-input p-relative">
                             
                              <button class="fill-btn" type="submit" onclick="location.href='{{url('/')}}';">
                                
                                 <span class="fill-btn-inner">
                                   Buy Now
                                    <span class="fill-btn-hover"> Buy Now</span>
                                 </span>
                              </button>
                           </div>
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
</body>

</html>
@endsection
@push('footerscript')
<script src="{{url('/')}}/giftcards/js/custom.js"></script>
<script src="{{url('/')}}/giftcards/js/giftcard.js"></script>
<script>
   function autocomplete(inp, arr) {
     /*the autocomplete function takes two arguments,
     the text field element and an array of possible autocompleted values:*/
     var currentFocus;
     /*execute a function when someone writes in the text field:*/
     inp.addEventListener("input", function(e) {
         var a, b, i, val = this.value;
         /*close any already open lists of autocompleted values*/
         closeAllLists();
         if (!val) { return false;}
         currentFocus = -1;
         /*create a DIV element that will contain the items (values):*/
         a = document.createElement("DIV");
         a.setAttribute("id", this.id + "autocomplete-list");
         a.setAttribute("class", "autocomplete-items");
         /*append the DIV element as a child of the autocomplete container:*/
         this.parentNode.appendChild(a);
         /*for each item in the array...*/
         for (i = 0; i < arr.length; i++) {
           /*check if the item starts with the same letters as the text field value:*/
           if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
             /*create a DIV element for each matching element:*/
             b = document.createElement("DIV");
             /*make the matching letters bold:*/
             b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
             b.innerHTML += arr[i].substr(val.length);
             /*insert a input field that will hold the current array item's value:*/
             b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
             /*execute a function when someone clicks on the item value (DIV element):*/
             b.addEventListener("click", function(e) {
                 /*insert the value for the autocomplete text field:*/
                 inp.value = this.getElementsByTagName("input")[0].value;
                 /*close the list of autocompleted values,
                 (or any other open lists of autocompleted values:*/
                 closeAllLists();
             });
             a.appendChild(b);
           }
         }
     });
     /*execute a function presses a key on the keyboard:*/
     inp.addEventListener("keydown", function(e) {
         var x = document.getElementById(this.id + "autocomplete-list");
         if (x) x = x.getElementsByTagName("div");
         if (e.keyCode == 40) {
           /*If the arrow DOWN key is pressed,
           increase the currentFocus variable:*/
           currentFocus++;
           /*and and make the current item more visible:*/
           addActive(x);
         } else if (e.keyCode == 38) { //up
           /*If the arrow UP key is pressed,
           decrease the currentFocus variable:*/
           currentFocus--;
           /*and and make the current item more visible:*/
           addActive(x);
         } else if (e.keyCode == 13) {
           /*If the ENTER key is pressed, prevent the form from being submitted,*/
           e.preventDefault();
           if (currentFocus > -1) {
             /*and simulate a click on the "active" item:*/
             if (x) x[currentFocus].click();
           }
         }
     });
     function addActive(x) {
       /*a function to classify an item as "active":*/
       if (!x) return false;
       /*start by removing the "active" class on all items:*/
       removeActive(x);
       if (currentFocus >= x.length) currentFocus = 0;
       if (currentFocus < 0) currentFocus = (x.length - 1);
       /*add class "autocomplete-active":*/
       x[currentFocus].classList.add("autocomplete-active");
     }
     function removeActive(x) {
       /*a function to remove the "active" class from all autocomplete items:*/
       for (var i = 0; i < x.length; i++) {
         x[i].classList.remove("autocomplete-active");
       }
     }
     function closeAllLists(elmnt) {
       /*close all autocomplete lists in the document,
       except the one passed as an argument:*/
       var x = document.getElementsByClassName("autocomplete-items");
       for (var i = 0; i < x.length; i++) {
         if (elmnt != x[i] && elmnt != inp) {
           x[i].parentNode.removeChild(x[i]);
         }
       }
     }
     /*execute a function when someone clicks in the document:*/
     document.addEventListener("click", function (e) {
         closeAllLists(e.target);
     });
   }
   
   /*An array containing all the country names in the world:*/
   var countries = {!! $search !!};
   
   /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
   autocomplete(document.getElementById("myInput"), countries);
   </script>
  
  
@endpush