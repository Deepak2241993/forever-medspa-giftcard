<?php $__env->startSection('body'); ?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Giftcards Sale</h3>
                   
                </div>
                <div class="sucess"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="<?php echo e(url('admin-dashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Giftcard Sale
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
            <div class="row g-4">
                <!-- Start column -->
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title">
                                Giftcard Sale
                            </div>
                        </div>
                   
                        <Form Method="post"action="<?php echo e(route('giftcard-purchase')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="amountdisplay" class="form-label">Amount<span class="text-danger">*</span></label>
                                    <input type="number" name="amount" class="form-control" min="25" max="2000" id="amountdisplay" Placeholder="Amount shoud be between $25 to $2000" onchange="amountcheck()" onkeyup="amountcheck()" required>
                                    <span class="text-danger" id="amounterror"></span>
                                    <input type="hidden" name="discount" class="form-control" min="0" id="discount" value="0">
                                    <input type="hidden" name="user_token" id="user_token" value="<?php echo e(Auth::user()->user_token); ?>" class="form-control">
                                    
                                </div>
                                <div class="mb-3">
                                    <label for="sqty" class="form-label">Quantity<span class="text-danger">*</span></label>
                                    <input type="number" name="qty" class="form-control" min="1" id="sqty" value="1" required>
                                    
                                </div>
                                <div class="mb-3">
                                    <label for="syour_name" class="form-label">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="your_name" class="form-control" id="syour_name"required>
                                </div>
                                <div class="mb-3">
                                    <label for="sto_email" class="form-label">Email<span class="text-danger">*</span></label>
                                    <input type="email" name="gift_send_to" class="form-control" id="sto_email"required>
                                </div>
                                <div class="mb-3">
                                    <label for="coupon_code" class="form-label">Coupon Code</label>
                                    <input type="text" class="form-control text-uppercase" id="coupon_code" name="coupon_code">
                                    <button onclick="CheckCoupon()" type="button"class="btn btn-success mt-2">Apply</button>
                                    <span class="text-danger" id="Coupon_error"></span>
                                    <span class="text-success" id="Coupon_success"></span>
                                </div>
                                                                
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" id="amount_pay" type="submit">Submit
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-3">
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    
    <!--end::App Content-->
</main>


  <!--  Redeem Modal -->
  <div class="modal fade deepak" id="redeem_" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Gift Card Number</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="get" action="<?php echo e(route('giftcard-search')); ?>">
                <div style="display: flex; flex-direction: column;">
                    <label for="giftnumber_" style="margin-right: 10px;">Gift Number:</label>
                    <input  class="giftnumber_"type="text" id="giftnumber_" name="giftnumber" value="" style="margin-right: 20px;" readonly>

                    <label for="amount_" style="margin-right: 10px;">Amount:</label>
                    <input  type="number" id="amount_" class="amount_" min="1" max="" name="amount" style="margin-right: 20px;">
            
                    <label for="comments_" style="margin-right: 10px;">Comments</label>
                    <textarea class="form-control comments_" name="comments" id="comments_" style="margin-right: 20px;"></textarea>
            
                    <input type="hidden" class="user_token" name="user_token" value="<?php echo e(Auth::user()->user_token); ?>">
                    <input type="hidden" class="user_id" id="user_id_" name="user_id" value="">
            
                    <button type="button" class="btn btn-primary mt-3 redeembutton" id="" onclick="redeemgiftcard(event)">Redeem</button>
                </div>
            </form>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  

  <div class="modal fade Statment" id="Statment_" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Gift Card History</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="statment_view table table-striped">
               
            </table>
            
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <?php $__env->stopSection(); ?>

  <?php $__env->startPush('script'); ?>
   <script>
    //  for amount check 
    function amountcheck(){
        var pre_amount = $('#amountdisplay').val();
        if (pre_amount < 25) {
            $('#amounterror').html('The Amount should be more than or equal to $25');
            return false;
        }
        else if (pre_amount > 2000) {
            $('#amounterror').html('Your amount is more than $2000. Please enter an amount less than or equal to $2000');
            return false;
        }
        else{
            $('#amounterror').html('');
        }
}

    //  for coupon validate
    function CheckCoupon() {
    var coupon_code = $('#coupon_code').val();
    var pre_amount = $('#amountdisplay').val();
    if(pre_amount<25)
    {
        alert('The Amount should be more than or equal to $25');
        return false;
    }
    if(pre_amount>2000)
    {
        alert('Your is more the $2000 please enter less then $2000 or equal to $2000');
        return false;
    }
    var qty = $('#sqty').val();
    var amount=qty*pre_amount;

    //  Fovalidation code 

    $.ajax({
        url: '<?php echo e(route('coupon-validate')); ?>',
        method: "post",
        dataType: "json",
        data: {
            _token: '<?php echo e(csrf_token()); ?>',
            coupon_code: $("#coupon_code").val(),
            user_token: $('#user_token').val(),
            amount: amount,
        },
        success: function (response) {
            if (response.success) {
                $('#Coupon_error').hide();
                $('#Coupon_success').html(response.success).show();
				if(response.data[0]['discount_type']=='amount')
				{
					var discountAmount = response.data[0]['discount_rate'];
					var afterDiscount = parseInt(amount - discountAmount);
					$("#discount").val(discountAmount);
				}
				if(response.data[0]['discount_type']=='percentage')
				{
					var discountRate = response.data[0]['discount_rate']; // Assuming discount_rate is a percentage (e.g., 10 for 10%)
					var discountAmount = (amount * discountRate) / 100;
					var afterDiscount = amount - discountAmount;
					$("#discount").val(discountAmount);
                    $("#amount_pay").html('Pay $'+afterDiscount);
				}
				
            } 
			if (response.error) {
                $('#Coupon_success').hide();
                $('#Coupon_error').html(response.error).show();
				// $("#coupon_code").val('');

            } 
        }
    });
}
    </script>
    
  <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u929332160/domains/myforevermedspa.com/public_html/resources/views/gift/gift_sale.blade.php ENDPATH**/ ?>