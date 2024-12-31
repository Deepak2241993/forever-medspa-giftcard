
    <!-- Main Sidebar Container -->

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('root') }}" class="brand-link">
            <img src="{{ url('/medspa.png') }}" alt="Forever Medspa" class="brand-image img-circle elevation-3"
                style="opacity: .8" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
            <span class="brand-text font-weight-light">Forever Medspa</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar" style="overflow-x: auto; overflow-y: auto; max-height: 100vh; max-width: 100%;">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="@if (Auth::guard('patient')->user()->image != '') {{ URL::asset(Auth::guard('patient')->user()->image) }}@else{{ URL::asset('medspa.png') }} @endif"
                        class="img-circle elevation-2" height="50" width="50" alt="User Image" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
                </div>
                <div class="info">
                    <a href="#" class="d-block"> {{ Auth::guard('patient')->user()->fname  }}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button  class="btn btn-block btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                       
                    </li>
                    <li class="nav-header">Orders</li>

                    <li class="nav-item">
                        <a 
                            href="{{route('purchased-giftcards') }}" 
                            class="nav-link">
                            <i class="nav-icon fas fa-solid fa-gift"></i>
                            <p>
                                Giftcards
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a 
                            href="{{route('patient-giftcards-redeem') }}" 
                            class="nav-link">
                            <i class="nav-icon fas fa-solid fa-gift"></i>
                            <p>
                                Giftcards Redeem
                            </p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-user-md"></i>
                            <p>
                                My Services
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">2</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('service-order-history.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Service Buy</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('service-redeem-view') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p> Service Redeem History</p>
                                </a>
                            </li>
                           
                        </ul>
                    </li>

                    {{-- Patient Management  --}}
                    
                    <li class="nav-header">Profile Settings</li>
                    <li class="nav-item">
                        <a 
                            href="{{route('patient-profile') }}" 
                            class="nav-link">
                            <i class="nav-icon far fa-user"></i>
                            <p>
                                Profile
                            </p>
                        </a>
                    </li>
                    
                   
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link">
                            <i class="nav-icon fa fa-power-off"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                    </li>


                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

