
<?php $__env->startSection('body'); ?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Search Keywords</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Search Keywords
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
            
               <a href="<?php echo e(route('export_date')); ?>" class="btn btn-primary">Click For Data Export</a>
            <div class="card-header">
               
               <span class="text-success"> <?php if(session()->has('success')): ?>
                    <?php echo e(session()->get('success')); ?>

                <?php endif; ?></span>
            </div>
           
            
            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Keywords Search</th>
                    <th>No.of Search</th>
                   </tr>
                </thead>
                 <tbody>
                    <?php $__currentLoopData = $keywordsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($value->keywords ? $value->keywords:'NULL'); ?></td>
                        <td><?php echo e($value->keyword_count ? $value->keyword_count :'NULL'); ?></td>
                        
                        
                        
                        <!-- Button trigger modal -->

  

                       
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php echo e($keywordsData->links('vendor.pagination.default')); ?>

           
           
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

  <?php $__env->startPush('script'); ?>
  
    
  <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\MedsapGiftCardNew\resources\views/admin/product/keyword_report.blade.php ENDPATH**/ ?>