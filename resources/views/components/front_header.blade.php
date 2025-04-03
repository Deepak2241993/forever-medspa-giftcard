<header class="top-header">
    <nav class="navbar header-nav navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{url('/')}}"><img src="{{url('/images/gifts/logo.png')}}" alt="image" style="height:81px;" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-wd" aria-controls="navbar-wd" aria-expanded="false" aria-label="Toggle navigation">
                
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbar-wd">
                <ul class="navbar-nav">
                    <li><a class="nav-link" href="https://forevermedspanj.com/" target="_blank">Home</a></li>
                    {{-- <li>
                        <a class="nav-link {{ Request::is('services') ? 'active' : '' }}" href="{{ route('services') }}">
                            Black Friday Deals
                        </a>
                    </li> --}}
                    <li><a class="nav-link active" href="{{url('/')}}">Giftcards</a></li> 
                    
                   
                    @if(Session::get('patient_details'))
                     <li><a class="nav-link" href="{{route('patient-dashboard')}}">{{ Auth::guard('patient')->user()->fname }}</a></li> 
                    @else
                     <li><a class="nav-link" href="{{url('/patient-login')}}">Login</a></li> 
                     @endif
                    {{-- Cart Code --}}
                    @php
                    $cart = session()->get('cart', []);
                    $amount=0;
                    
                    @endphp
                    @if(count(session()->get('cart', []))>0)
                    <div id="cart"  class="btn btn-group">
                        <button onclick="window.location.href='{{route('cartview')}}'" type="button" data-toggle="dropdown" data-loading-text="Loading..."  class="btn btn-inverse btn-lg dropdown-toggle"><i class="fa fa-shopping-bag"></i> <span id="cart-total" class="hidden-xs">{{ count(session()->get('cart', [])) ? count(session()->get('cart', [])) : 0 }}
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