       <!--begin::Start Navbar Links-->
       <ul class="navbar-nav">
           <li class="nav-item">
               <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                   <i class="fa-solid fa-bars"></i>
               </a>
           </li>
           <li class="nav-item d-none d-md-block">
               <a href="{{ url('/users/user-dashboard') }}" class="nav-link">Dashboard</a>
           </li>
           <li class="nav-item d-none d-md-block">
               <a href="{{ url('/') }}" class="nav-link">Go to Website</a>
           </li>
           @if(count(session()->get('cart', []))>0)
           <li class="nav-item d-none d-md-block">
                        <div id="cart" class="btn-group btn-block">
                            <button onclick="window.location.href='{{route('service-cart')}}'" type="button" data-toggle="dropdown" data-loading-text="Loading..." class="btn btn-inverse btn-block btn-lg dropdown-toggle"><i class="fa fa-shopping-bag"></i> <span id="cart-total" class="hidden-xs">{{ count(session()->get('cart', [])) ? count(session()->get('cart', [])) : 0 }}
                            </span></button>
                            {{-- <ul class="dropdown-menu pull-right">    <li>
                                <p class="text-center">Your shopping cart is empty!</p>
                              </li>  </ul> --}}
                        </div>
            </li>
             @endif
       </ul>
       <!--end::Start Navbar Links-->
       <ul class="navbar-nav ms-auto">
           <!--end::Notifications Dropdown Menu-->
           <!--begin::User Menu Dropdown-->
           <li class="nav-item dropdown user-menu">
               <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                   <img src="@if (Auth::user()->avatar != '') {{ URL::asset(Auth::user()->avatar) }}@else{{ URL::asset('medspa.png') }} @endif"
                       class="user-image rounded-circle shadow" alt="User Image">
                   <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
               </a>
               <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                   <!--begin::User Image-->
                   <li class="user-header text-bg-primary">
                       <img src="@if (Auth::user()->avatar != '') {{ URL::asset(Auth::user()->avatar) }}@else{{ URL::asset('medspa.png') }} @endif"
                           class="rounded-circle shadow" alt="User Image">

                       <p>
                           {{ Auth::user()->name }}
                           {{-- <small>Member since Nov. 2023</small> --}}
                       </p>
                   </li>
                   <!--end::User Image-->

                   <!--begin::Menu Footer-->
                   <li class="user-footer">
                       <a href="#" class="btn btn-default btn-flat">Profile</a>
                       <a href="{{ url('/logout') }}" class="btn btn-default btn-flat float-end">Sign out</a>
                   </li>
                   <!--end::Menu Footer-->
               </ul>
           </li>
           <!--end::User Menu Dropdown-->
       </ul>
