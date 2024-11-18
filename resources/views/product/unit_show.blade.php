@extends('layouts.front_product')
@section('body')
@push('css')

@endpush
@section('body')
!-- Body main wrapper start -->
   <main>

      <!-- Breadcrumb area start  -->
      <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
         <div class="breadcrumb__thumb" data-background="{{url('/uploads/FOREVER-MEDSPA')}}/med-spa-banner.jpg"></div>
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-xxl-12">
                  <div class="breadcrumb__wrapper text-center">
                     <h2 class="breadcrumb__title">{{$product->product_name}}</h2>
                     <div class="breadcrumb__menu">
                        <nav>
                           <ul>
                              <li><span><a href="{{url('/')}}">Home</a></span></li>
                              <li><span>{{$product->product_name}}</span></li>
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
            <div class="row">
                @foreach($result as $key => $value)
                @php
                    $unit = App\Models\ServiceUnit::find($value);
                    $image = explode('|',$unit->product_image);

                @endphp
                <div class="col-md-4">
                    <div class="card">
                        @if(!empty($image[0]!=''))
                        <img src="{{$image[0]}}" class="card-img-top" alt="...">
                        @else
                        <img src="{{url('/No_Image_Available.jpg')}}" class="card-img-top" alt="...">
                        @endif
                        <div class="card-body">
                            <div class="content p-4">
                                <h4>{{ $unit ? $unit->product_name : '' }}</h4>
                                <p class="card-text">
                                    {{ $unit ? $unit->short_description : '' }}
                                </p>
                                <a href="{{route('unit-details',$unit->product_slug)}}" class="fill-btn cart-btn">
                                    <span class="fill-btn-inner">
                                    <span class="fill-btn-normal">Buy Now</span>
                                    <span class="fill-btn-hover">Buy Now</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

                
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
             quantity: 1,
             type: "unit"
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