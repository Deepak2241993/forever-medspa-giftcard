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
    <?php if(isset($result)): ?>
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
        <center>
            <div id="myDiv">
                <div class="box" style="height:70%;
                width: 50%;
                border: solid 1px;
                text-align: left;
                padding: 4px;">
                <img class="mb-4" id="logosuccess" src="https://forevermedspanj.com/wp-content/uploads/forever-color.fw_.png" height="60px">
                <table class="table mt-4" style="margin-top: 20px;">
                    <thead>
                        <tr><td colspan="2"><h2>Transaction Details</h2></td></tr>
                      <tr>
                        <th>Gift Receiver's Name</th><td>
                            <?php if(isset($result->recipient_name)): ?>
                            <?php echo e($result->recipient_name); ?>

                            <?php else: ?>
                            <?php echo e($result->your_name); ?>

                            <?php endif; ?>

                        </td></tr>
                      <tr><th>Giftcard Sent To </th><td> <?php echo e($result->gift_send_to); ?></td></tr>
                      <tr><th>Payment Method </th><td><?php echo e($result->payment_mode); ?></td></tr>
                      <tr><th>Giftcard Amount</th><td><?php echo e($result->amount/$result->qty); ?></td></tr>
                      <tr><th>Giftcard Quantity</th><td><?php echo e($result->qty); ?></td></tr>
                      <tr><th>Total Amount</th><td><?php echo e($result->amount); ?></td></tr>
                      <tr style="background-color: #00800047;"><th>Discount</th><td><?php echo e($result->discount); ?></td></tr>
                      <tr style="background-color: orange;"><th>Payable Amount</th><td><?php echo e($result->transaction_amount); ?></td></tr>
                      <tr><th>Transaction ID</th><td><?php echo e($result->transaction_id); ?></td></tr>
                      <tr><th>Transaction Date&Time</th><td><?php echo e(date('m-d-Y h:i:s', strtotime($result->payment_time))); ?></td></tr>
                      <tr style="background-color: <?php echo e($result->payment_status=='succeeded'?'#00800047':'orange'); ?>;"><th>Payment Status</th><td><?php echo e($result->payment_status); ?></td></tr>
                      <tr><td colspan="2"></td></tr>
                        <tr><td colspan="2"><h2>Gift Card Number</h2></td></tr>
                        <tr><th>Card Number</th><td>Amount</td></tr>
                        
                        <?php if(isset($result->card_number)): ?>

                        <?php $__currentLoopData = $result->card_number; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr><th><?php echo e($value['giftnumber']); ?></th><td><?php echo e($value['amount']); ?></td></tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <h3>No Card Number Has Been Generated Because the Payment Is Under Process</h3>

                        <?php endif; ?>
                        
                        
                    </thead>
                </table>
            </div>
        </div>
            <button class="btn btn-warning mt-4"onclick="printDiv()"> Print</button>
        </center>
                
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
    <?php else: ?>
    <h1>No Data Found</h1>
    <?php endif; ?>
</main>

  <?php $__env->stopSection(); ?>

  <?php $__env->startPush('script'); ?>
  <script>
    function printDiv() {
        var divToPrint = document.getElementById('myDiv');
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><head><title>Print</title></head><body><center>' + divToPrint.innerHTML + '</center></body></html>');
        newWin.document.close();
        $('.box').css('border', '1px solid');
        newWin.print();
    }
</script>
  <?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\giftcard\resources\views/gift/gift_purchase_payment_history.blade.php ENDPATH**/ ?>