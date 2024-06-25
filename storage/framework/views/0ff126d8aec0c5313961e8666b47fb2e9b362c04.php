<?php if(Auth::user()->user_type==0): ?>

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="<?php echo e(route('root')); ?>" class="brand-link">
            <!--begin::Brand Image-->
            <img src="<?php echo e(url('/medspa.png')); ?>" alt="Medspa Logo" class="brand-image opacity-75 shadow">
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Forever Medspa</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="<?php echo e(url('/')); ?>" class="nav-link active">
                        <i class="fa-solid fa-desktop"></i>
                        <p>
                            Dashboard
                            <i class="nav-arrow fa-solid fa-angle-right"></i>
                        </p>
                    </a>
                 
                </li>
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link">
                        <i class="nav-icon fa-solid fa-box-open"></i>
                        <p>
                        Items for sale
                        <span class="nav-badge badge text-bg-secondary opacity-75 me-3">3</span>
                            <i class="nav-arrow fa-solid fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('gift-category.index')); ?>" class="nav-link">
                                <i class="nav-icon fa-regular fa-circle"></i>
                                <p>Gift Category List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('medspa-gift.index')); ?>" class="nav-link">
                                <i class="nav-icon fa-regular fa-circle"></i>
                                <p>Gifts Cards Management</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('coupon.index')); ?>" class="nav-link">
                                <i class="fa-solid fa-ticket"></i>
                                <p>Coupon Management</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link">
                        <i class="nav-icon fa-solid fa-copy"></i>
                        <p>
                            Orders
                          
                            <i class="nav-arrow fa-solid fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('all-order-history.index')); ?>" class="nav-link">
                                <i class="nav-icon fa-regular fa-circle"></i>
                                <p>All Orders</p>
                            </a>
                        </li>
                       
                    </ul>
                </li>
                <li class="nav-header">Settings</li>
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link">
                        <i class="fa-solid fa-gear"></i>
                        <p>
                           Profile Settings
                            <i class="nav-arrow fa-solid fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../examples/login.html" class="nav-link">
                                <i class="nav-icon fa-regular fa-circle"></i>
                                <p>Login v1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../examples/register.html" class="nav-link">
                                <i class="nav-icon fa-regular fa-circle"></i>
                                <p>Register v1</p>
                            </a>
                        </li>
                    </ul>
                </li>

                
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>













<?php else: ?>

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="<?php echo e(route('root')); ?>" class="brand-link">
            <!--begin::Brand Image-->
            <img src="<?php echo e(url('/medspa.png')); ?>" alt="Medspa Logo" class="brand-image opacity-75 shadow">
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Forever Medspa</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="<?php echo e(route('root')); ?>" class="nav-link active">
                        <i class="fa-solid fa-desktop"></i>
                        <p>
                            Dashboard
                            <i class="nav-arrow fa-solid fa-angle-right"></i>
                        </p>
                    </a>
                 
                </li>
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link">
                        <i class="fa-solid fa-ticket"></i>
                        <p>
                        Coupon Management
                       
                            <i class="nav-arrow fa-solid fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        
                        <li class="nav-item">
                            <a href="<?php echo e(route('coupon.index')); ?>" class="nav-link">
                                <i class="nav-icon fa-regular fa-circle"></i>
                                <p>Coupon Management</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link">
                        <i class="fa-solid fa-receipt"></i>
                        <p>
                            Giftcards Orders
                          
                            <i class="nav-arrow fa-solid fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('cardgenerated-list')); ?>" class="nav-link">
                                <i class="nav-icon fa-regular fa-circle"></i>
                                <p>Giftcards Generated</p>
                            </a>
                        </li>
                       
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link">
                        <i class="fa-solid fa-barcode"></i>
                        <p>
                            Redeem Process 
                          
                            <i class="nav-arrow fa-solid fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('giftcardredeem-view')); ?>" class="nav-link">
                                <i class="nav-icon fa-regular fa-circle"></i>
                                <p>Redeem Giftcards</p>
                            </a>
                        </li>
                                              
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link">
                        <i class="fa-solid fa-gift"></i>
                        <p>
                            Gift Card Sale
                            <i class="nav-arrow fa-solid fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('giftcards-sale')); ?>" class="nav-link">
                                <i class="nav-icon fa-regular fa-circle"></i>
                                <p>Sale Gift Card</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link">
                        <i class="fa-regular fa-envelope"></i>
                        <p>
                           Email Template
                            <i class="nav-arrow fa-solid fa-angle-right"></i>
                        </p>
                    </a>
                    
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('email-template.index')); ?>" class="nav-link">
                                <i class="nav-icon fa-regular fa-circle"></i>
                                <p>Template Management</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link">
                        <i class="fa-brands fa-product-hunt"></i>
                        <p>
                            Product Management
                            <i class="nav-arrow fa-solid fa-angle-right"></i>
                        </p>
                    </a>
                    
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('category.index')); ?>" class="nav-link">
                                <i class="nav-icon fa-regular fa-circle"></i>
                                <p>Category Management</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('product.index')); ?>" class="nav-link">
                                <i class="nav-icon fa-regular fa-circle"></i>
                                <p>Product Management</p>
                            </a>
                        </li>
                    </ul>
                </li>
               
                <li class="nav-header">Settings</li>
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link">
                        <i class="fa-solid fa-gear"></i>
                        <p>
                           Profile Settings
                            <i class="nav-arrow fa-solid fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('logout')); ?>" class="nav-link">
                                <i class="nav-icon fa-regular fa-circle"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                      
                    </ul>
                </li>

                
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\MedsapGiftCardNew\resources\views/components/sidebar.blade.php ENDPATH**/ ?>