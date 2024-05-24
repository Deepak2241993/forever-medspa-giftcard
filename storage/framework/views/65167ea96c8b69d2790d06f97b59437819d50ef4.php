       <!--begin::Start Navbar Links-->
       <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="fa-solid fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-md-block">
            <a href="<?php echo e(url('/users/user-dashboard')); ?>" class="nav-link">Dashboard</a>
        </li>
        <li class="nav-item d-none d-md-block">
            <a href="<?php echo e(url('/')); ?>" class="nav-link">Go to Website</a>
        </li>
    </ul>
    <!--end::Start Navbar Links-->
<ul class="navbar-nav ms-auto">
    <!--end::Notifications Dropdown Menu-->
    <!--begin::User Menu Dropdown-->
    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <img src="<?php if(Auth::user()->avatar != ''): ?><?php echo e(URL::asset(Auth::user()->avatar)); ?><?php else: ?><?php echo e(URL::asset('medspa.png')); ?><?php endif; ?>" class="user-image rounded-circle shadow" alt="User Image">
            <span class="d-none d-md-inline"><?php echo e(Auth::user()->name); ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            <!--begin::User Image-->
            <li class="user-header text-bg-primary">
                <img src="<?php if(Auth::user()->avatar != ''): ?><?php echo e(URL::asset(Auth::user()->avatar)); ?><?php else: ?><?php echo e(URL::asset('medspa.png')); ?><?php endif; ?>" class="rounded-circle shadow" alt="User Image">

                <p>
                    <?php echo e(Auth::user()->name); ?>

                    
                </p>
            </li>
            <!--end::User Image-->

            <!--begin::Menu Footer-->
            <li class="user-footer">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
                <a href="<?php echo e(url('/logout')); ?>" class="btn btn-default btn-flat float-end">Sign out</a>
            </li>
            <!--end::Menu Footer-->
        </ul>
    </li>
    <!--end::User Menu Dropdown-->
</ul><?php /**PATH /home/u929332160/domains/myforevermedspa.com/public_html/resources/views/components/topbar.blade.php ENDPATH**/ ?>