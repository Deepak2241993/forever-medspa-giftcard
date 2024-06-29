
<?php $__env->startSection('body'); ?>
<style>
    .scroll-container {
  width: 100%; /* Set the width of the container */
  overflow-x: auto; /* Enable horizontal scrolling */
  white-space: nowrap; /* Make sure all elements are in one line */
}

.scroll-content {
  display: inline-block; /* Make sure content stays in one line */
  /* Optionally set a min-width to prevent content from squishing */
  min-width: 100%; /* Set to the width of your content */
}
.swal-text {
    font-size: 21px;
    position: relative;
    float: none;
    line-height: normal;
    vertical-align: top;
    text-align: left;
    display: inline-block;
    margin: 0;
    padding: 0 10px;
    font-weight: 700;
    color: #0e0e0f;
    /* max-width: calc(100% - 20px); */
    /* overflow-wrap: break-word; */
    box-sizing: border-box;
}
    </style>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">All Giftcards Transactions</h3>
                   
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?php echo e(url('admin-dashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Giftcards Transactions
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
            
            <div class="card-header">
                <?php if(session()->has('error')): ?>
                  <p class="text-danger">  <?php echo e(session()->get('error')); ?></p>
                <?php endif; ?>
                <?php if(session()->has('success')): ?>
                <p class="text-success"> <?php echo e(session()->get('success')); ?></p>
                <?php endif; ?>
            </div>
            <span class="text-success"id="response_msg"></span>
            <div class="scroll-container">
                <div class="scroll-content">
            <?php if(count($data)>0): ?>
            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Receiver Name</th>
                    <th>Received From</th>
                    <!--<th>Message</th>-->
                    <th>Sender's Email</th>
                    <th>Coupon Code</th>
                    <th>Number of Giftcards</th>
                    <th>Amount Per Giftcard</th>
                    <th>Discount</th>
                    <th>Paid Amount</th>
                    <th>Payment Status</th>
                    <th>Transaction Id</th>
                    <th>Generated Date & Time</th>
                    <th>Giftcard Number</th>
                    <th>Send Mail</th>
                                  </tr>
                </thead>
                 <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($value['recipient_name'] ? $value['recipient_name']:$value['your_name']); ?></td>
                        <td>
                            <?php if($value['payment_mode']=='Payment Gateway'): ?>
                            <?php echo e($value['recipient_name'] ? $value['your_name']:'Self'); ?>

                            <?php else: ?>
                            <?php echo e(Auth::user()->user_token); ?>

                            <?php endif; ?>
                        </td>
                        <!--<td><?php echo e($value['recipient_name'] ? $value['message']:'NULL'); ?></td>-->
                        <td><?php echo e($value['recipient_name'] ? $value['receipt_email']:'Medspa'); ?></td>
                        <td class="text-uppercase"><?php echo e($value['coupon_code'] ? $value['coupon_code']:'----'); ?></td>
                        <td><?php echo e($value['qty'] ? $value['qty']:'----'); ?></td>
                        <td><?php echo e($value['amount'] ?   '$'.$value['amount']:'$ 0'); ?></td>
                        <td><?php echo e($value['discount'] ?   '$'.$value['discount']:'$ 0'); ?></td>
                        <td><?php echo e($value['transaction_amount'] ?   '$'.$value['transaction_amount']:'$ 0'); ?></td>
                        
                        <td>
                            <?php if($value['payment_status']=='succeeded'): ?>
                            <span class="badge text-bg-success"><?php echo e(ucFirst($value['payment_status'])); ?></span>
                        <?php elseif($value['payment_status']=='processing'): ?>
                            <span class="badge text-bg-primary"><?php echo e(ucFirst($value['payment_status'])); ?></span>
                            <a href="#">
                                <span class="badge text-bg-warning" data-bs-toggle="modal" data-bs-target="#paymentUpdate_<?php echo e($value['id']); ?>" onclick="modalopen(<?php echo e($value['id']); ?>, '<?php echo e($value['transaction_id']); ?>')">Update Status</span>
                            </a>
                        <?php elseif($value['payment_status']=='amount_capturable_updated'): ?>
                            <span class="badge text-bg-warning"><?php echo e(ucFirst($value['payment_status'])); ?></span>
                        <?php elseif($value['payment_status']=='payment_failed'): ?>
                            <span class="badge text-bg-danger"><?php echo e(ucFirst($value['payment_status'])); ?></span>
                        <?php else: ?>
                            <span class="badge text-bg-danger">Incompleted</span>
                        <?php endif; ?>                        
                           </td>
                        <td><?php echo e($value['transaction_id']); ?></td>
                        
                        <td><?php echo date('m-d-Y h:i:A', strtotime($value['created_at'])); ?></td>
                        <td><a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop_<?php echo e($value['id']); ?>" onclick="cardview(<?php echo e($value['id']); ?>,'<?php echo e($value['transaction_id']); ?>')">
                            View Card
                        </a></td>
                        <td>
                            <?php if($value['payment_status']=='succeeded'): ?>
                            <a href="<?php echo e(route('Resendmail_view', ['id' => $value['id']])); ?>" class="btn btn-warning" id="mailsend_<?php echo e($value['id']); ?>">Mail Resend</a>
                            
                            <?php endif; ?>
                        </td>
                        
                        <!-- Button trigger modal -->

  

                       
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <hr>
            <p> No data found</p>
            <?php endif; ?>
                
                </tbody>
            </table>
        </div>
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

<div class="modal fade paymentUpdate" id="paymentUpdate_" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="paymentstatus" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentstatus">Payment Status Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div style="display: flex; flex-direction: column;">
                        <label for="transaction_id_" style="margin-right: 10px;">Transaction id:</label>
                        <input class="transaction_id form-control" type="text" id="transaction_id_" name="giftnumber" value="" style="margin-right: 20px;" readonly>

                        <label for="payment_status_" style="margin-right: 10px;">Update Status</label>
                        <select name="payment_status" class="form-control status_id" id="payment_status_">
                            <option value="">Select Status</option>
                            <option value="succeeded">Succeeded</option>
                            <option value="processing">Processing</option>
                        </select>

                        <label for="comments_" style="margin-right: 10px;">Comments</label>
                        <textarea class="form-control comments_" name="comments" id="comments_" style="margin-right: 20px;"></textarea>

                        <input type="hidden" class="user_token" name="user_token" value="<?php echo e(Auth::user()->user_token); ?>">
                        <input type="hidden" class="gift_id" id="gift_id_" name="id" value="">

                        <button type="button" class="btn btn-primary mt-3 paymentstatusbutton" id="paymentstatusbutton" gift_id="gift_id_" onclick="updatestatus(event)" ><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>Update</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



  <!-- for Show Gift card Number Modal -->
  <div class="modal fade deepak" id="staticBackdrop_" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Gift Card Number</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <h2 id="giftcardsshow"></h2>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <?php $__env->stopSection(); ?>

  <?php $__env->startPush('script'); ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
<script>
    // for payment status Modal Open
    function modalopen(id,transaction_id) {
    $('#paymentUpdate_').attr('id', 'paymentUpdate_' + id);
    $('#transaction_id_').attr('id', 'transaction_id_' + id).val();
    $('#transaction_id_'+id).val(transaction_id);
    $('#payment_status_').attr('id', 'payment_status_' + id).val();
    $('.paymentstatusbutton').attr('id','paymentstatusbutton_' + id).val();
    $('.paymentstatusbutton').attr('gift_id',id).val();
    $('#gift_id_').attr('id', 'gift_id_' + id).val(id);
    $('#comments_').attr('id', 'comments_' + id).val();
    $('#paymentUpdate_' + id).modal('show');
    
}

function updatestatus(event) {
    var id = event.target.getAttribute('gift_id');
    var button = $('#paymentstatusbutton_' + id);
    button.attr('disabled', true);
    button.find('.spinner-border').show();
    $.ajax({
        url: '<?php echo e(route('giftcard-payment-update')); ?>',
        method: "post",
        dataType: "json",
        data: {
            _token: '<?php echo e(csrf_token()); ?>',
            transaction_id: $('#transaction_id_' + id).val(),
            id: $('#gift_id_' + id).val(),
            comments: $('#comments_' + id).val(),
            user_token: '<?php echo e(Auth::user()->user_token); ?>',
            payment_status: $('#payment_status_' + id).val(),
        },
        success: function(response) {
            console.log(response.msg);
            if (response) {
                $('#paymentUpdate_' + id).modal('hide');
                $('#response_msg').html(response.msg);
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            } 
        },
        complete: function() {
            button.attr('disabled', false); // Enable button after AJAX call
            button.find('.spinner-border').hide();
        }
    });
}



function cardview(id,tid) {
    $('.deepak').attr('id', 'staticBackdrop_' + id);
    $('#staticBackdrop_' + id).modal('show');

    $.ajax({
        url: '<?php echo e(route('cardview-route')); ?>',
        method: "post",
        dataType: "json",
        data: {
            _token: '<?php echo e(csrf_token()); ?>',
            tid: tid,
            user_token: '<?php echo e(Auth::user()->user_token); ?>',
        },
        success: function(response) {
            if (response.success) {
                $('#giftcardsshow').empty();
                $.each(response.result, function(index, element) {
                // Create a new element with the giftnumber
                var newElement = $('<div>').html(element.giftnumber);
                
                // Append the new element to #giftcardsshow
                $('#giftcardsshow').append(newElement);
            });
              
            }
        }
    });
}

//  
function sendmail(id, tid){
    //  For adding spinner
    var button = $('#mailsend_' + id);
    button.attr('disabled', true);
    button.find('.spinner-border').show();
    // spinner code end

    $.ajax({
        url: '<?php echo e(route('Resendmail_view')); ?>',
        method: "post",
        dataType: "json",
        data: {
            _token: '<?php echo e(csrf_token()); ?>',
            tid: tid,
            id: id,
            user_token: '<?php echo e(Auth::user()->user_token); ?>',
        },
        success: function(response) {
            console.log(response.message);
            if (response.message) {
                swal("",response.message,"success");
                button.attr('disabled', false);
                button.find('.spinner-border').hide();
            }
            else{
                swal("",response.error,"error");
                button.attr('disabled', false);
                button.find('.spinner-border').hide();
            }
        }
    });
}



    </script>
    
  <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\MedsapGiftCardNew\resources\views/admin/cardnumber/index.blade.php ENDPATH**/ ?>