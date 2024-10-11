@extends('layouts.front_product')
@section('body')
@push('css')

@endpush
@section('body')
!-- Body main wrapper start -->
   <main>

      <!-- Breadcrumb area start  -->
      <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
         <div class="breadcrumb__thumb" data-background="{{url('/uploads/FOREVER-MEDSPA')}}/Slide_4.jpg"></div>
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-xxl-12">
                  <div class="breadcrumb__wrapper text-center">
                     <h2 class="breadcrumb__title">{{$data->product_name}}</h2>
                     <div class="breadcrumb__menu">
                        <nav>
                           <ul>
                              <li><span><a href="{{url('/')}}">Home</a></span></li>
                              <li><span>{{$data->product_name}}</span></li>
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Breadcrumb area start  -->

      <!-- Product details area start -->
      <div class="product__details-area section-space-medium">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-xxl-6 col-lg-6">
                  <div class="product__details-thumb-wrapper d-sm-flex align-items-start mr-50">
                     <div class="product__details-thumb-tab mr-20">
                        <nav>
                           <div class="nav nav-tabs flex-nowrap flex-sm-column" id="nav-tab" role="tablist">
                              @php 
                              $image= explode('|',$data->product_image)
                              @endphp
                               @foreach($image as $key=>$image_name)
                               @if($key<=2)
                              <button class="nav-link {{$key==0?'active':''}}" id="img-{{$key}}-tab" data-bs-toggle="tab"
                                 data-bs-target="#img-{{$key}}" type="button" role="tab" aria-controls="img-{{$key}}"
                                 aria-selected="true">
                                 <img src="{{$image_name}}" alt="product-sm-thumb">
                              </button>
                              @endif
                              @endforeach
                           </div>
                        </nav>
                     </div>
                     <div class="product__details-thumb-tab-content">
                        <div class="tab-content" id="productthumbcontent">
                          
                           @foreach($image as $key=>$image_name)
                           @if($key<=2)
                           <div class="tab-pane fade {{$key==0?'show active':''}}" id="img-{{$key}}" role="tabpanel"
                              aria-labelledby="img-{{$key}}-tab">
                              <div class="product__details-thumb-big w-img">
                                 <img src="{{$image_name}}" alt="">
                              </div>
                           </div>
                           @endif
                           @endforeach
                          
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xxl-6 col-lg-6">
                  <div class="product__details-content pr-80">
                     {{-- <div class="product__details-top d-sm-flex align-items-center mb-15">
                        <div class="product__details-tag mr-10">
                           <a href="#">Construction</a>
                        </div>
                        <div class="product__details-rating mr-10">
                           <a href="#"><i class="fa-solid fa-star"></i></a>
                           <a href="#"><i class="fa-solid fa-star"></i></a>
                           <a href="#"><i class="fa-regular fa-star"></i></a>
                        </div>
                        <div class="product__details-review-count">
                           <a href="#">10 Reviews</a>
                        </div>
                     </div> --}}
                     <h3 class="product__details-title">{{$data->product_name}}</h3>
                     <div class="product__details-price">
                        <span class="old-price">${{$data->amount}}</span>
                        <span class="new-price">${{$data->discounted_amount}}</span>
                     </div>
                     <p>{!! $data->short_description !!}</p>

                     <div class="product__details-action mb-35">
                        <div class="product__quantity">
                           <div class="product-quantity-wrapper">
                              <form action="#">
                                 <button class="cart-minus">Session : {{$data->session_number}}</button>
                                 {{-- <input class="cart-input" type="text" value="1"> --}}
                                 {{-- <button class="cart-plus"><i class="fa-light fa-plus"></i></button> --}}
                              </form>
                           </div>
                        </div>
                        <div class="product__add-cart">
                           <a href="javascript:void(0)" class="fill-btn cart-btn" onclick="addcart({{$data->id}})">
                              <span class="fill-btn-inner">
                                 <span class="fill-btn-normal">Add To Cart<i
                                       class="fa-solid fa-basket-shopping"></i></span>
                                 <span class="fill-btn-hover">Add To Cart<i
                                       class="fa-solid fa-basket-shopping"></i></span>
                              </span>
                           </a>
                        </div>
                        {{-- <div class="product__add-wish">
                           <a href="{{route('checkout')}}" class="fill-btn cart-btn">
                              <span class="fill-btn-inner">
                                 <span class="fill-btn-normal">Buy Now</span>
                                 <span class="fill-btn-hover">Buy Now</span>
                              </span>
                           </a>
                        </div> --}}
                     </div>
                     {{-- <div class="product__details-meta mb-20">
                       
                        <div class="categories">
                           <span>Categories:</span> <a href="#">Milk,</a> <a href="#">Cream,</a> <a
                              href="#">Fermented.</a>
                        </div>
                        
                     </div> --}}
                     <div class="product__details-share">
                        <span>Share:</span>
                        <a href="http://www.facebook.com/sharer.php?u={{url()->current()}}"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://twitter.com/share?url={{url()->current()}}"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://instagram.com/api/v1/media/upload/{{url()->current()}}"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="product__details-additional-info section-space-medium-top">
               <div class="row">
                  <div class="col-xxl-3 col-xl-4 col-lg-4">
                     <div class="product__details-more-tab mr-15">
                        <nav>
                           <div class="nav nav-tabs flex-column " id="productmoretab" role="tablist">
                              <button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab"
                                 data-bs-target="#nav-description" type="button" role="tab"
                                 aria-controls="nav-description" aria-selected="true">Description</button>
                              <button class="nav-link" id="nav-additional-tab" data-bs-toggle="tab"
                                 data-bs-target="#nav-additional" type="button" role="tab"
                                 aria-controls="nav-additional" aria-selected="false">Prerequisites Information </button>
                              {{-- <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab"
                                 data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-review"
                                 aria-selected="false">Reviews</button>
                           </div> --}}
                        </nav>
                     </div>
                  </div>
                  <div class="col-xxl-9 col-xl-8 col-lg-8">
                     <div class="product__details-more-tab-content">
                        <div class="tab-content" id="productmorecontent">
                           <div class="tab-pane fade show active" id="nav-description" role="tabpanel"
                              aria-labelledby="nav-description-tab">
                              <div class="product__details-des">
                                 {!! $data->product_description !!}
                              </div>
                           </div>
                           <div class="tab-pane fade" id="nav-additional" role="tabpanel"
                              aria-labelledby="nav-additional-tab">
                              <div class="product__details-info">
                                 {!! $data->product_description !!}
                              </div>
                           </div>
                           {{-- <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                              <div class="product__details-review">
                                 <h3 class="comments-title">03 reviews for “Wide Cotton Tunic extreme hammer”</h3>
                                 <div class="latest-comments mb-50">
                                    <ul>
                                       <li>
                                          <div class="comments-box d-flex">
                                             <div class="comments-avatar mr-10">
                                                <img src="assets/imgs/user/user-01.png" alt="">
                                             </div>
                                             <div class="comments-text">
                                                <div
                                                   class="comments-top d-sm-flex align-items-start justify-content-between mb-5">
                                                   <div class="avatar-name">
                                                      <h5>Siarhei Dzenisenka</h5>
                                                      <div class="comments-date">
                                                         <span>March 27, 2018 9:51 am</span>
                                                      </div>
                                                   </div>
                                                   <div class="user-rating">
                                                      <ul>
                                                         <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                         <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                         <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                         <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                         <li><a href="#"><i class="fal fa-star"></i></a></li>
                                                      </ul>
                                                   </div>
                                                </div>
                                                <p>This is cardigan is a comfortable warm classic piece. Great to layer
                                                   with a light top and you can dress up or down given the jewel
                                                   buttons. I’m 5’8” 128lbs a 34A and the Small fit fine.</p>
                                             </div>
                                          </div>
                                       </li>
                                       <li>
                                          <div class="comments-box d-flex">
                                             <div class="comments-avatar mr-10">
                                                <img src="assets/imgs/user/user-02.png" alt="">
                                             </div>
                                             <div class="comments-text">
                                                <div
                                                   class="comments-top d-sm-flex align-items-start justify-content-between mb-5">
                                                   <div class="avatar-name">
                                                      <h5>Siarhei Dzenisenka</h5>
                                                      <div class="comments-date">
                                                         <span>March 27, 2018 9:51 am</span>
                                                      </div>
                                                   </div>
                                                   <div class="user-rating">
                                                      <ul>
                                                         <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                         <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                         <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                         <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                         <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                      </ul>
                                                   </div>
                                                </div>
                                                <p>I bought this beautiful pale gray cashmere sweater for my
                                                   daughter-in-law for her birthday. She loves it and can wear it with
                                                   almost anything!</p>
                                             </div>
                                          </div>
                                       </li>
                                       <li>
                                          <div class="comments-box d-flex">
                                             <div class="comments-avatar mr-10">
                                                <img src="assets/imgs/user/user-03.png" alt="">
                                             </div>
                                             <div class="comments-text">
                                                <div
                                                   class="comments-top d-sm-flex align-items-start justify-content-between mb-5">
                                                   <div class="avatar-name">
                                                      <h5>Siarhei Dzenisenka</h5>
                                                      <div class="comments-date">
                                                         <span>March 27, 2018 9:51 am</span>
                                                      </div>
                                                   </div>
                                                   <div class="user-rating">
                                                      <ul>
                                                         <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                         <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                         <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                         <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                         <li><a href="#"><i class="fal fa-star"></i></a></li>
                                                      </ul>
                                                   </div>
                                                </div>
                                                <p>Amazing club. Sure the secruity is very tight but actually made me
                                                   and my friends feel secure. You just have to go along with the
                                                   secruity. Bar staff and cloakroom staff really friendly. Coming out
                                                   at 7am into bright London sunshine in Smithfields is an amazing
                                                   London experience</p>
                                             </div>
                                          </div>
                                       </li>
                                    </ul>
                                 </div>
                                 <div class="product__details-comment section-space-medium-bottom">
                                    <div class="comment-title mb-20">
                                       <h3>Add a review</h3>
                                       <p>Your email address will not be published. Required fields are marked *</p>
                                    </div>
                                    <div class="comment-rating mb-20">
                                       <span>Overall ratings</span>
                                       <ul>
                                          <li><a href="#"><i class="fas fa-star"></i></a></li>
                                          <li><a href="#"><i class="fas fa-star"></i></a></li>
                                          <li><a href="#"><i class="fas fa-star"></i></a></li>
                                          <li><a href="#"><i class="fas fa-star"></i></a></li>
                                          <li><a href="#"><i class="fal fa-star"></i></a></li>
                                       </ul>
                                    </div>
                                    <div class="comment-input-box">
                                       <form action="#">
                                          <div class="row">
                                             <div class="col-xxl-12">
                                                <div class="comment-input">
                                                   <textarea placeholder="Your review"></textarea>
                                                </div>
                                             </div>
                                             <div class="col-xxl-6">
                                                <div class="comment-input">
                                                   <input type="text" placeholder="Your Name*">
                                                </div>
                                             </div>
                                             <div class="col-xxl-6">
                                                <div class="comment-input">
                                                   <input type="email" placeholder="Your Email*">
                                                </div>
                                             </div>
                                             <div class="col-xxl-12">
                                                <div class="comment-agree d-flex align-items-center mb-25">
                                                   <input class="z-check-input" type="checkbox" id="z-agree">
                                                   <label class="z-check-label" for="z-agree">Save my name, email, and
                                                      website in this browser for the next time I comment.</label>
                                                </div>
                                             </div>
                                             <div class="col-xxl-12">
                                                <div class="comment-submit">
                                                   <button type="submit" class="fill-btn">
                                                      <span class="fill-btn-inner">
                                                         <span class="fill-btn-normal">submit now</span>
                                                         <span class="fill-btn-hover">submit now</span>
                                                      </span>
                                                   </button>
                                                </div>
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div> --}}
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Product details area end -->

   </main>
   <!-- Body main wrapper end -->
@endsection

@push('footerscript')
<script>
   function addcart(id) {
    $.ajax({
        url: '{{ route('cart') }}',
        method: "post",
        dataType: "json",
        data: {
            _token: '{{ csrf_token() }}',
            product_id: id,
            quantity: 1
        },
        success: function (response) {
            if (response.success) {
                window.location.href = '{{ route('cartview') }}'; 
            } else {
                $('.showbalance').html(response.error).show();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle the error here
            $('.showbalance').html('An error occurred. Please try again.').show();
        }
    });
}

</script>
@endpush
