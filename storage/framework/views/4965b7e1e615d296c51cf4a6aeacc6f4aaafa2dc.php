<?php $__env->startSection('body'); ?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Coupon Create</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?php echo e(url('admin-dashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Coupon Create
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
            <div class="card-body p-4">
                <?php if(isset($giftCoupon)): ?>

                <form method="post" action="<?php echo e(route('coupon.update',$giftCoupon->id)); ?>" enctype="multipart/form-data">
                    <?php echo method_field('PUT'); ?>
                <?php else: ?>
                    <form method="post" action="<?php echo e(route('coupon.store')); ?>" enctype="multipart/form-data">
                <?php endif; ?>
            
                    <?php echo csrf_field(); ?>
                    <div class="row">

                        <div class="mb-3 col-lg-6 self">
                            <label for="title" class="form-label">Coupon Title<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="title" value="<?php echo e(isset($giftCoupon)?$giftCoupon->title:''); ?>" placeholder="Coupon Title" id="title" required>
                        </div>
                        <?php if(count($gatcategory)>0): ?>
                        <div class="mb-3 col-lg-6 self">
                            <label for="title" class="form-label">Select Category<span class="text-danger">*</span></label>
                           <select  class="form-control" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php $__currentLoopData = $gatcategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value->id); ?>"<?php echo e(isset($giftCoupon)&&$giftCoupon->category_id==$value->id?'selected':''); ?>><?php echo e($value->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </div>
                        <?php endif; ?>
                        <div class="mb-3 col-lg-6 self">
                            <label for="coupon_code" class="form-label">Coupon Code<span class="text-danger">*</span></label>
                            <input class="form-control text-uppercase" type="text" name="coupon_code" value="<?php echo e(isset($giftCoupon)?$giftCoupon->coupon_code:''); ?>" placeholder="Coupon Code" id="coupon_code"required>
                            <input class="form-control" type="text" hidden name="user_token" value="<?php echo e(Auth::user()->user_token); ?>" placeholder="Set Condition" id="coupon_code" readonly required>
                        </div>
                        
                        <div class="mb-3 col-lg-6 self">
                            <label for="apply_condition" class="form-label">Condition For Apply<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="apply_condition" value="<?php echo e(isset($giftCoupon)?$giftCoupon->apply_condition:'Amount<100'); ?>" placeholder="Enter Coupon Code" id="apply_condition"required>
                        </div>
                        <div class="mb-3 col-lg-2 self">
                            <label for="discount_type" class="form-label">Discount Type<span class="text-danger">*</span></label>
                            <select class="form-control" name="discount_type" id='discount_type' required>
                                <option value="">Select Discount</option>
                                <option value="amount"<?php echo e(isset($giftCoupon->discount_type) && $giftCoupon->discount_type == 'amount' ? 'selected' : ''); ?>>Amount</option>
                                <option value="percentage"<?php echo e(isset($giftCoupon->discount_type) && $giftCoupon->discount_type == 'percentage' ? 'selected' : ''); ?>>Percentage</option>
                            </select>
                        </div>
                        <div class="mb-3 col-lg-4 self">
                            <label for="discount_rate" class="form-label">Discount Percent or Amount<span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="discount_rate" value="<?php echo e(isset($giftCoupon)?$giftCoupon->discount_rate:''); ?>" placeholder="Discout Rate OR Amount" id="discount_rate" required>
                        </div>
                        <div class="mb-3 col-lg-6 self">
                            <label for="redeem_description" class="form-label">Redeem Description</label>
                            <textarea class="form-control" id="redeem_description" name="redeem_description"><?php echo e(isset($giftCoupon)?$giftCoupon->redeem_description:''); ?></textarea>

                        </div>
                        <div class="mb-3 col-lg-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="status" id='status'>
                                <option value="1"<?php echo e(isset($giftCoupon->status) && $giftCoupon->status == 1 ? 'selected' : ''); ?>>Active</option>
                                <option value="0"<?php echo e(isset($giftCoupon->status) && $giftCoupon->status == 0 ? 'selected' : ''); ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3 col-lg-6 mt-4">
                            
                            <button class="btn btn-primary" type="submit" name="submit">Submit</button>
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


<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u929332160/domains/myforevermedspa.com/public_html/resources/views/coupon/create.blade.php ENDPATH**/ ?>