<?php $__env->startSection('body'); ?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">All-Coupon</h3>
                   
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?php echo e(url('admin-dashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            All-Coupon
                        </li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <a href="<?php echo e(route('coupon.create')); ?>" class="btn btn-primary">Add More</a>
            <div class="card-header">
                <?php if(session()->has('error')): ?>
                    <?php echo e(session()->get('error')); ?>

                <?php endif; ?>
                <?php if(session()->has('success')): ?>
                    <?php echo e(session()->get('success')); ?>

                <?php endif; ?>
            </div>
            <?php if(count($data)>0): ?>
            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    
                    <th>Discount</th>
                    <th>Code</th>
                    <th>Created At</th>
                    <th>Status</th>
                    <?php if(Auth::user()->user_type==1): ?>
                    <th>Action</th>
                    <?php endif; ?>
                </tr>
                </thead>


                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($value->title); ?></td>
                    
                    <td><?php echo e($value->discount_type == 'amount' ? '$ '.$value->discount_rate : $value->discount_rate.' %'); ?></td>
                    <td><?php echo e($value->coupon_code); ?></td>
                    <td><?php echo e($value->created_at); ?></td>
                    <td> <?php echo e($value->status == 1 ? 'Active' : 'Inactive'); ?></td>
                    <th>
                        <a href="<?php echo e(route('coupon.edit',$value->id)); ?>" class="btn btn-primary">Edit</a>

                        <form action="<?php echo e(route('coupon.destroy',$value->id)); ?>" method="POST">
                            <?php echo method_field('DELETE'); ?>
                            <?php echo csrf_field(); ?> <!-- Include CSRF token for security -->
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                        
                        
                       
                    </th>
                    
                   
                </tr>
               
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                </tbody>
            </table>
            <?php else: ?>
            <p> No data found</p>
            <?php endif; ?>
            <!--end::Row-->               
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>
<?php $__env->stopSection(); ?>






<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\giftcard\resources\views/coupon/index.blade.php ENDPATH**/ ?>