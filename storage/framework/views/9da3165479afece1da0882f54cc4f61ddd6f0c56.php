
<?php $__env->startSection('body'); ?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Email Template</h3>
                   
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Email Template
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
            <a href="<?php echo e(route('email-template.create')); ?>" class="btn btn-primary">Add More</a>
            <div class="card-header">
                <?php if(session()->has('error')): ?>
                    <?php echo e(session()->get('error')); ?>

                <?php endif; ?>
                <?php if(session()->has('success')): ?>
                    <?php echo e(session()->get('success')); ?>

                <?php endif; ?>
            </div>
            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Action</th>
                  
                </tr>
                </thead>


                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($value->title); ?></td>
                    <td><?php if(!empty($value->image)): ?><image src="<?php echo e($value->image); ?>" height="100px" width="100px"><?php endif; ?></td>
                    <td><?php echo e(substr($value->message_email,0,100)); ?></td>

                    <td><?php echo e($value->status==1 ? 'Active':'Deactive'); ?></td>
                    <td><a href="<?php echo e(route('email-template.edit',$value->id)); ?>" class="btn btn-primary"><i class="bx bx-pencil"></i>Edit </a>
                        <form method="post" action="<?php echo e(route('email-template.destroy',$value->id)); ?>">
                        <?php echo method_field('DELETE'); ?>
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are You sure')"><i class="bx bx-trash-alt"></i>Delete</button>
                    
                </form></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                </tbody>
            </table>
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














<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\MedsapGiftCardNew\resources\views/email_template/index.blade.php ENDPATH**/ ?>