
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
                        class="img-circle elevation-2" alt="User Image" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
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
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('root') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                           
                        </ul>
                    </li>
                    <li class="nav-header">Giftcards Orders</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-gift"></i>
                            <p>
                                Giftcards
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">3</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('cardgenerated-list') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Giftcard Orders</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('giftcardredeem-view') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Giftcard Redeem</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('giftcards-sale') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sale Gift Card</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-header">Services Orders</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-user-md"></i>
                            <p>
                                Services
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">3</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('service-order-history.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Service Orders</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('service-redeem-view') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p> Service Redeem</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('product.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Service & Deals Sale</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    
                    
                    

                    {{-- Patient Management  --}}
                    <li class="nav-header">Patient Management</li>
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-heartbeat"></i>
                          <p>
                            Patient Management
                              <i class="fas fa-angle-left right"></i>
                               {{-- <span class="badge badge-info right">2</span> --}}
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('patient.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-book-medical"></i>
                                <p>
                                    Patient List

                                </p>
                            </a>
                        </li>
                      </ul>
                    </li>
                   
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link">
                            <i class="nav-icon far fa-user"></i>
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

