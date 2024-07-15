
<?php $__env->startSection('body'); ?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Category Create</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                           Category Add/Update
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
       <span class="text-danger"> <?php if(session()->has('error')): ?>
        <?php echo e(session()->get('error')); ?>

    <?php endif; ?></span>
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="card-body p-4">
                <?php if(isset($data)): ?>
                
                <form method="post" action="<?php echo e(route('category.update',$data['id'])); ?>" enctype="multipart/form-data">
                    <?php echo method_field('PUT'); ?>
                <?php else: ?>
                    <form method="post" action="<?php echo e(route('category.store')); ?>" enctype="multipart/form-data">
                <?php endif; ?>
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="mb-3 col-lg-6 self">
                            <label for="title" class="form-label">Category Name</label>
                            <input class="form-control" type="text" name="cat_name" value="<?php echo e(isset($data)?$data['cat_name']:''); ?>" placeholder="Category Name">
                        </div>
                       
                        <div class="mb-12 col-lg-12 self">
                            <label for="cat_description" class="form-label">Category Description</label>
                            <textarea name="cat_description"  id="cat_description" rows="4" class="form-control"><?php echo e(isset($data)?$data['cat_description']:''); ?></textarea>
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="image" class="form-label">Category Image</label>
                            <?php if(isset($data['cat_image'])): ?>
                            <img src="<?php echo e($data['cat_image']); ?>" style="width:80%; height:100px;"><span> <buttom class="btn btn-danger">X</buttom></span>
                        <?php endif; ?>
                            <input class="form-control" id="image" type="file" name="cat_image">
                        </div>
                       
                        <div class="mb-3 col-lg-6">
                            <label for="from" class="form-label">Status</label>
                            <select class="form-control" name="status" id="from">
                                <option value="1"<?php echo e(isset($data['status']) && $data['status'] == 1 ? 'selected' : ''); ?> >Active</option>
                                <option value="0"<?php echo e(isset($data['status']) && $data['status'] == 0 ? 'selected' : ''); ?>>Inactive</option>
                            </select>
                        </div>
                 
                        <div class="mb-3 col-lg-6">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
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
    
<script>
    CKEDITOR.replace( 'cat_description', {
     height: 300,
     filebrowserUploadUrl: "<?php echo e(url('/ckeditor')); ?>/script.php"
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\MedsapGiftCardNew\resources\views/admin/product/category_create.blade.php ENDPATH**/ ?>