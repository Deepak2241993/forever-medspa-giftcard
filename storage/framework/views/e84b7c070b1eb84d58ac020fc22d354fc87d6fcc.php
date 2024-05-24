<?php $__env->startSection('body'); ?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Giftcard Payment Review</h3>
                   
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?php echo e(url('admin-dashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Payment Review
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
            <table class="table">
                <thead>
                  <tr><th>Name</th><td><?php echo e($result->your_name); ?></td></tr>
                  <tr><th>Giftcard Sent To </th><td><?php echo e($result->gift_send_to); ?></td></tr>
                  <tr><th>Payment Method </th><td><?php echo e($result->payment_mode); ?></td></tr>
                  <tr><th>Giftcard Amount</th><td><?php echo e($result->amount); ?></td></tr>
                  <tr><th>Giftcard Quantity</th><td><?php echo e($result->qty); ?></td></tr>
                  <tr><th>Total Amount</th><td><?php echo e($result->amount*$result->qty); ?></td></tr>
                  <tr style="background-color: #00800047;"><th>Discount</th><td><?php echo e($result->discount); ?></td></tr>
                  <tr style="background-color: orange;"><th>Payable Amount</th><td><?php echo e($result->amount*$result->qty-$result->discount); ?></td></tr>
                  <tr><td>
                    <form method="post" action="<?php echo e(route('payment_cnf')); ?>">
                        <?php echo csrf_field(); ?>
                        <label for amount>Amount</label>
                        <input type="number" min="0" name="transaction_amount" class="form-control" id="amount" value="<?php echo e($result->amount*$result->qty-$result->discount); ?>" readonly>
                        <?php if(isset($result->transaction_id)&& !empty($result->transaction_id)): ?>
                        <label for transaction_id>Enter Transaction Id</label>
                        <input type="text" readonly value="<?php echo e($result->transaction_id); ?>" name="transaction_id" class="form-control" id="transaction_id">
                        <?php else: ?>
                        <label for transaction_id>Enter Transaction Id</label>
                        <input type="text" value="" name="transaction_id" class="form-control" id="transaction_id">
                        <?php endif; ?>
                        <input type="hidden" value="<?php echo e($result->id); ?>" name="id" class="form-control" value="" readonly>
                        <input type="hidden" name="user_token" id="user_token" value="<?php echo e(Auth::user()->user_token); ?>" class="form-control">
                        <input type="hidden" value="<?php echo e($result->your_name); ?>" name="your_name" class="form-control" value="">
                        <input type="hidden" value="<?php echo e($result->gift_send_to); ?>" name="gift_send_to" class="form-control" value="">
                        <input type="hidden" value="<?php echo e($result->payment_mode); ?>" name="payment_mode" class="form-control" value="">

                        <label for transaction_id>Payment Status</label>
                        <select name="payment_status" class="form-control" id="transaction_id">
                            <option value="">Select Status</option>
                            <option value="processing">Processing</option>
                            <option value="succeeded">Succeeded</option>
                    </select>

                        <input type="submit"  class="btn btn-success mt-2" value="Submit">
                          <a href="<?php echo e(route('giftcards-sale')); ?>" class="btn btn-danger mt-2">Cancel</a>
                    </td>
                    </form>
                  </tr>
                </thead>
                
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

  <?php $__env->startPush('script'); ?>
       
  <?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u929332160/domains/myforevermedspa.com/public_html/resources/views/gift/gift_purchase_payment_history.blade.php ENDPATH**/ ?>