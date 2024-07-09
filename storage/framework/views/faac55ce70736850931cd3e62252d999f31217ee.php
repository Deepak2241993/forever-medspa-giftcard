
<?php $__env->startSection('body'); ?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Service Create</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                           Service Add/Update
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
                
                <form method="post" action="<?php echo e(route('product.update',$data['id'])); ?>" enctype="multipart/form-data">
                    <?php echo method_field('PUT'); ?>
                <?php else: ?>
                    <form method="post" action="<?php echo e(route('product.store')); ?>" enctype="multipart/form-data">
                <?php endif; ?>
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="mb-3 col-lg-6 self">
                            <label for="product_name" class="form-label">Service Name</label>
                            <input class="form-control" type="text" name="product_name" value="<?php echo e(isset($data)?$data['product_name']:''); ?>" placeholder="Product Name">
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="cat_id" class="form-label">Service Category</label>
                            <select name="cat_id" class="form-control">
                                <option value="">Select Category</option>
                                <?php if($category): ?>
                                    <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value['id']); ?>" <?php echo e(isset($data['id']) && $data['cat_id'] == $value['id'] ? 'selected' : ''); ?>><?php echo e($value['cat_name']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <option>No Category Found</option>
                                <?php endif; ?>
                            </select>
                            
                        </div>
                       
                        <div class="mb-12 col-lg-12 self">
                            <label for="product_description" class="form-label">Service Description</label>
                            <textarea name="product_description"  id="product_description" class="form-control summernote"><?php echo e(isset($data)?$data['product_description']:''); ?></textarea>
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="product_image" class="form-label">Service Image</label><br>
                            <?php if(isset($data['product_image'])): ?>
                                <div id="image_class">
                                    <img src="<?php echo e($data['product_image']); ?>" class="mb-4" style="width:80%; height:100px;"><span> <buttom class="btn btn-danger" onclick="hideImage()">X</buttom></span>
                                </div>
                            <?php endif; ?>
                            <div id="image_field" style="display:<?php echo e(isset($data['id'])?'none':'block'); ?>">
                                <input class="form-control" id="image" type="file" name="product_image">
                            </div>
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="discounted_amount" class="form-label">Service Discounted Price</label>
                            <input class="form-control" type="number" min="0" name="discounted_amount" value="<?php echo e(isset($data)?$data['discounted_amount']:''); ?>" placeholder="Product Name">
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="amount" class="form-label">Service Amount MRP</label>
                            <input class="form-control" type="number" min="0" name="amount" value="<?php echo e(isset($data)?$data['amount']:''); ?>" placeholder="Product Name">
                            <input class="form-control" type="hidden" min="0" name="id" value="<?php echo e(isset($data)?$data['id']:''); ?>">
                        </div>
                        
                       
                        <div class="mb-3 col-lg-6">
                            <label for="from" class="form-label">Status</label>
                            <select class="form-control" name="status" id="from">
                                <option value="1"<?php echo e(isset($data['status']) && $data['status'] == 1 ? 'selected' : ''); ?> >Active</option>
                                <option value="0"<?php echo e(isset($data['status']) && $data['status'] == 0 ? 'selected' : ''); ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3 col-lg-6 mt-5">
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
function hideImage(){
$('#image_class').hide();
$('#image_field').show();
}
</script>

<script>

    $(document).ready(function() {
      $('.summernote').summernote({
        popover: {
          image: [
    
            // This is a Custom Button in a new Toolbar Area
            ['custom', ['examplePlugin']],
            ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
            ['float', ['floatLeft', 'floatRight', 'floatNone']],
            ['remove', ['removeMedia']]
          ]
        }
      });
    });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\MedsapGiftCardNew\resources\views/admin/product/product_create.blade.php ENDPATH**/ ?>