
<?php $__env->startSection('body'); ?>
<style>
   .main_box_coupon{
     background-image: url('<?php echo e(url("/giftcards/images/coupon.png")); ?>');
     width: 570px;
     height: 107px;
      align-items: center;
    justify-content: center;
  }
    .main_box_coupon .box_coupon {
    float: right;
    display: flex;
    width: 100%;
    justify-content:end !important;

    }
   .main_box_coupon .single-coupon-content{
      margin-top: 0px;

   }

</style>
<!-- wish -->
<div class="about-box" style="padding-bottom: 0;">
<div class="about-a1" style="background:#f7f7f7;margin-top: 50px; padding: 40px 20px 50px 20px;">
   <div class="container">
      <input type="hidden" id="user_token"value="FOREVER-MEDSPA"placeholder=""/>
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="row align-items-center about-main-info">
               <div class="col-lg-6 col-md-6 col-sm-12">
                          <h2><b>Giftcards made simple</b>
                          </h2>
                          <p style="text-align: justify;">We're thrilled to express our gratitude to the loyal customers of MedSpa Wellness centre, with our !  Whether it's a token of appreciation, a celebration, or a simple gesture of kindness, our gift cards provide the perfect opportunity to share the joy of our products and services. Delight your loved ones with the freedom to explore and indulge in what they love most. With each gift card, we're extending our heartfelt thanks for your continued support and patronage. Spread the joy and make someone's day a little brighter with our gift cards</p>
                   
                   
                    <?php if(isset($coupon_code) && count($coupon_code)>0): ?>
                              <hr>
                                <h4 class="mt-2 mb-2">Get your Coupon and Save more!</h4>
                                <hr>
                               
                               
                                <?php $__currentLoopData = $coupon_code; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($key<5): ?>
                               <div class="row main_box_coupon mt-2">
                                 <div class="col-md-3"></div>
                                 <div class="col-md-5">
                                    <strong style="margin-left: 2px;margin-right: 2px;font-size:22px;text-align: center;"><?php echo e($value->title?$value->title:''); ?></strong>
                                        <p style="font-weight: 700;margin-left: 5px;margin-right: 18px;text-align: center;"><?php echo e($value->title?$value->redeem_description:''); ?></p>
                                 </div>
                                 <div class="col-md-4" style="text-align:center">
                                       <span class="mt-2"> Coupon Code<h3><b><?php echo e($value->title?$value->coupon_code:''); ?></b></h3></span>
                                 </div>
                               </div>
                  
                            
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

  
               </div>
               <div class="col-lg-6 col-md-6 col-sm-12 text_align_center">
                  <div>
                     <?php if(session()->has('message')): ?>
                     <?php echo e(session()->get('message')); ?>

                     <?php endif; ?>
                     <!-- MultiStep Form -->
                     <div class="row justify-content-center mt-0">
                        <div class="col-11 col-sm-9 col-md-7 col-lg-11 text-center p-0 mt-3 mb-2">
                           <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                              <h2><strong>Send Gift Cards </strong></h2>
                              <p>Fill all form field to go to next step</p>
                              <div class="row">
                                 <div class="col-md-12 mx-0">
                                    <div id="msform">
                                       <!-- progressbar -->
                                       <ul id="progressbar">
                                          <li class="active" id="gift"><strong>Gift</strong></li>
                                          <li id="personal"><strong>Personal</strong></li>
                                          <li id="payment"><strong>Payment</strong></li>
                                          
                                       </ul>
                                       <!-- fieldsets -->
                                       <fieldset id="firstbox">
                                          <ul class="list-group">
                                             <li class="list-group-item"><span class="giftlist">$25 gift card</span>
                                                <span class="giftamount">$25</span>
                                                <button class="btn btn-warning" type="button"onclick="fixamount(25)">Buy</button>
                                             </li>
                                             <li class="list-group-item"><span class="giftlist">$50 gift card</span>
                                                <span class="giftamount">$50</span>
                                                <button class="btn btn-warning" type="button"onclick="fixamount(50)">Buy</button>
                                             </li>
                                             <li class="list-group-item"><span class="giftlist">$75 gift card</span>
                                                <span class="giftamount">$75</span>
                                                <button class="btn btn-warning" type="button"onclick="fixamount(75)">Buy</button>
                                             </li>
                                             <li class="list-group-item"><span class="giftlist">$100 gift card</span>
                                                <span class="giftamount">$100</span>
                                                <button class="btn btn-warning" type="button"onclick="fixamount(100)">Buy</button>
                                             </li>
                                             <li class="list-group-item">
                                                <span class="giftlist">Choose an amount…</span><span class="giftamount">
                                                <div class="row">
                                                   <div class="col-md-8" style="max-width: 62%;">
                                                      <input type="number" step="1" min="25" max="2000"  id="customeamount" size="8"placeholder="$25" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"></div>
                                                   <div class="col-md-3">
                                                      <button class="btn btn-warning" type="button"onclick="customeamount()">Buy
                                                      </button>
                                                   </div>
                                                </div>
                                             </li>
                                             <p class="p-2">Give the gift of rejuvenation and relaxation with a Medspa gift card - perfect for you and your friends!</p>
                                             <p class="text-warning p-2" onclick="checkbalance()" href="javascript:void(0)">Check your gift card balance</p>
                                          </ul>
                                          
                                       </fieldset>
                                       <fieldset id="secondbox">
                                          <h2 id="amountdisplay" amount="0" finalAmount="0" coupondiscount="0"></h2>
                                          <p>For use at Forever Medspa Clinic</p>
                                          <div class="button-group ml-4">
                                             <button type="button"class="btn btn-light active" id="someone" onclick="someOneElse('someone')"><i class="fa fa-gift" aria-hidden="true"></i> Someone else</button>
                                             <button type="button"class="btn btn-light" id="self"onclick="someOneElse('self')"><i class="fa fa-user" aria-hidden="true"></i> Yourself</button>
                                          </div>
                                          <form id ="someoneform" method="post" enctype="multipart/form-data" class="p-4 text-left">
                                             <?php echo csrf_field(); ?>
                                             <div class="row">
                                                <!-- /ko -->
                                                <div class="mb-3 col-lg-12 self">
                                                   <label for="to_1" class="form-label">Quantity</label>
                                                   <select class="form-control" name="qty" id="qty" onchange="qtychange()">
                                                   <?php for($i=1; $i<=10;$i++): ?>
                                                   <option value="<?php echo e($i); ?>"<?php echo e($i==1?'selected':''); ?>><?php echo e($i); ?></option>
                                                   <?php endfor; ?>
                                                   </select>
                                                </div>
                                                <div class="mb-3 col-lg-12 self">
                                                   <label for="your_name" class="form-label">Your name<span class="text-danger">*</span></label>
                                                   <input class="form-control" type="text" name="your_name" value="" placeholder="From Name" id="your_name" autocomplete="off" required>
                                                   <input type="hidden" value="0" name="template_id">
                                                </div>
                                                <div class="mb-3 col-lg-12">
                                                   <label for="recipient_name" class="form-label">Recipient name<span class="text-danger">*</span></label>
                                                   <input class="form-control" type="text" name="to_name" value="" placeholder="To Name" id="recipient_name" autocomplete="off" required>
                                                </div>
                                                <div class="mb-3 col-lg-12">
                                                   <label for="message" class="form-label">Message<span class="text-danger">*</span></label>
                                                   <textarea name="msg" id="message" autocomplete="off" rows="4" class="form-control"></textarea>
                                                </div>
                                                <div class="button-group">
                                                   
                                                   
                                                </div>
                                                <div id="emailfields">
                                                   <div class="mb-3 col-lg-12 mt-2" id="giftSendByEmail">
                                                      <label for="recipient_email" class="form-label"><b>What email address should we send the gift card to?<span class="text-danger">*</span></b></label>
                                                      <input class="form-control" type="email" name="to_email" value="" placeholder="Recipient Email Address" id="gift_send_to" autocomplete="off" required>
                                                   </div>
                                                   <div class="mb-3 col-lg-12 mt-2" id="giftSendByEmail">
                                                      <label for="recipient_email" class="form-label"><b>Your email address (for the receipt)<span class="text-danger">*</span></b></label>
                                                      <input class="form-control" type="email" name="from_email" value="" placeholder="Sender's Email address (for the receipt)" id="recipient_email" autocomplete="off" required>
                                                   </div>
                                                   <div class="mb-3 col-lg-12 mt-2" id="giftSendByEmail">
                                                      <label for="recipient_email" class="form-label"><b>Select Event<span class="text-danger">*</span></b></label>

                                                      <select class="form-control" id="Event_id" name="">
                                                         <option value="">Select Event</option>
                                                         <?php $__currentLoopData = $occassion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                         <option value="<?php echo e($value->id); ?>"><?php echo e($value->title); ?></option>
                                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                      </select>
                                                      
                                                   </div>
                                                   <div class="mb-3 col-lg-12 d-flex align-items-center">
                                                      <label  class="form-label"><b>Send In Future:<span class="text-danger">*</span></b></label>
                                                    </div>
                                                    <div class="form-check form-check-inline mb-4">
                                                      <input class="form-check-input" type="radio" id="future_yes" value="yes" name="future_status" onclick="futureDate()" autocomplete="off">
                                                      <label class="form-check-label" for="future_yes">Send on a future date</label>
                                                    </div>
                                                  
                                                    <div class="form-check form-check-inline mb-4">
                                                      <input class="form-check-input" type="radio" id="future_no" value="no" checked name="future_status" onclick="futureDate()" autocomplete="off">
                                                      <label class="form-check-label" for="future_no">Send instantly</label>
                                                    </div>
                                                   <div class="mb-3 col-lg-12" id="future_date_section">
                                                      <label for="in_future" class="form-label"><b>Select Date</b></label>
                                                      <input class="form-control" id="in_future" type="date" name="future_date" autocomplete="off" required>
                                                      <span id="error_msg" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <hr/>
                                                <div class="row">
                                                   <div class="mb-3 col-lg-9">
                                                      <input class="text-uppercase" type="text"placeholder="Have a promo code?" id="coupon_code" message="">
                                                   </div>
                                                   <div class="col-md-3">
                                                      <button class="btn btn-warning" type="button"onclick="CheckCoupon()">Apply Code
                                                      </button>
                                                   </div>
                                                   <div class="text-success"style="margin-left: 20px;" id="Coupon_success"></div>
                                                   <div class="text-danger" style="margin-left: 20px;"id="Coupon_error"></div>
                                                </div>
                                                <div class="mb-3 col-lg-12 mt-2">
                                                   <button class="btn btn-primary" id="couponaply" onclick="sendsomeOneElse()" type="button" name="submit">Submit</button>
                                                   <button class="btn btn-warning" id="submitFormButton" type="button" onclick="firstboxshow()">Back</button>
                                                </div>
                                                <div class="mb-3 col-lg-12">
                                                   <p>Give the gift of rejuvenation and relaxation with a Medspa gift card - perfect for you and your friends! </p>
                                                   <p class="text-warning p-2" onclick="checkbalance()" href="javascript:void(0)">Check your gift card balance</p>
                                                </div>
                                             </div>
                                          </form>
                                          <form id="selfform" method="post" enctype="multipart/form-data" class="p-4 text-left">
                                             <?php echo csrf_field(); ?>
                                             <div class="row">
                                                <div class="mb-3 col-lg-12 self">
                                                   <label for="to_1" class="form-label">Quantity</label>
                                                   <select class="form-control" id="sqty" onchange="sqtychange()">
                                                   <?php for($i=1; $i<=10;$i++): ?>
                                                   <option value="<?php echo e($i); ?>" <?php echo e($i==1?'selected':''); ?>><?php echo e($i); ?></option>
                                                   <?php endfor; ?>
                                                   </select>
                                                </div>
                                                <div class="mb-3 col-lg-12 self">
                                                   <label for="syour_name" class="form-label">Your Name<span class="text-danger">*</span></label>
                                                   <input class="form-control" type="text" name="from_name" value="" placeholder="From Name" id="syour_name" required autocomplete="off">
                                                   <input type="hidden" value="0" name="template_id">
                                                </div>
                                                <div class="button-group">
                                                   <button type="button"class="btn btn-light active" id="onemail" onclick="giftsend('onemail')"><i class="fa fa-envelope" aria-hidden="true"></i> By email</button>
                                                   
                                                </div>
                                                <div class="mb-3 col-lg-12 mt-2" id="giftSendByEmail">
                                                   <label for="to_email_1" class="form-label"><b>What email address should we send the gift card to?<span class="text-danger">*</span></b></label>
                                                   <input class="form-control" type="email" name="to_email" value="" placeholder="Enter Your Email" id="sto_email" autocomplete="off" required>
                                                </div>
                                                <div class="row">
                                                   <div class="col-md-9">
                                                      <input class="text-uppercase" type="text"placeholder="Have a promo code?" id="scoupon_code" message="">
                                                   </div>
                                                   <div class="col-md-3">
                                                      <button class="btn btn-warning" type="button"onclick="SelfCoupon()">Apply Code
                                                      </button>
                                                   </div>
                                                   <div class="text-success" style="margin-left: 20px;" id="SCoupon_success"></div>
                                                   <div class="text-danger" style="margin-left: 20px;" id="SCoupon_error"></div>
                                                </div>
                                                <div class="mb-3 col-lg-12 mt-2">
                                                   <button class="btn btn-primary" onclick="selfValidation()" type="button" name="submit">Submit</button>
                                                   <button class="btn btn-warning" id="back" type="button" onclick="firstboxshow()">Back</button>
                                                </div>
                                                <hr/>
                                                <div class="mb-3 col-lg-12">
                                                   <p>Give the gift of rejuvenation and relaxation with a Medspa gift card - perfect for you and your friends!</p>
                                                   <p class="text-warning" onclick="checkbalance()" href="javascript:void(0)">Check your gift card balance</p>
                                                </div>
                                          </form>
                                       </fieldset>
                                       <fieldset id="paymentdbox" class="p-4">
                                       <h2 class="fs-title">Order summary</h2>
                                       <div id="paymentresult"></div>
                                       <form action="<?php echo e(url('/giftcardpayment')); ?>" method="POST" class="mb-4">
                                       <?php echo csrf_field(); ?>
                                       <div id="paymentscript"></div>
                                       </form>
                                       </fieldset>
                                       <div class="giftcardField">
                                       <div class="row p-4">
                                       <div class="col-md-8">
                                       <input type="text"placeholder="Enter gift card code.." id="gift_card_code">
                                       </div>
                                       <div class="col-md-3">
                                       <button class="btn btn-warning mb-4" type="button" onclick="check_balance()">Check Balance
                                       </button>
                                       </div> 
                                       </div>
                                       </div>  
                                       <span class="showbalance"></span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- wish us -->

<div id="redeem" class="services-box main-timeline-box">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="title-box">
               <h2><b>Redeem Process</b></h2>
            </div>
         </div>
      </div>
      <div class="row">
         <ol>
            <li>The customer needs to purchase the giftcard from<strong> https://myforevermedspa.com</strong></li>
            <li>After Purchasing the giftcard, the customer needs to visit the <strong>MedSpa Wellness Center</strong> to redeem the dedicated purchased Giftcard</li>
            <li>Admins at the Welness centre will check the details of the giftcard and process the transaction as per need of the customer</li>
         </ol>
      </div>
   </div>
</div>
<!-- best deals -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('footerscript'); ?>
<script src="<?php echo e(url('/')); ?>/giftcards/js/custom.js"></script>
<script src="<?php echo e(url('/')); ?>/giftcards/js/giftcard.js"></script>
<script src="https://ampath.com/asset/js/jquery.validate.min.js"></script>



<script>
   //  for self validation
   function selfValidation() {
       $("#selfform").validate({
           rules: {
               sqty: {
                   required: true,
               },
               syour_name: {
                   required: true,
                   minlength: 3,
               },
               sto_email: {
                   required: true,
                   email: true,
                   maxlength: 60,
               },
           },
           messages: {
               sqty: {
                   required: "Please select quantity",
               },
               syour_name: {
                   required: "Please enter your name",
                   minlength: "Please enter at least 3 characters",
               },
               sto_email: {
                   required: "This field is required",
                   email: "Please enter a valid email address",
                   maxlength: "Email length should not exceed 60 characters",
               },
           },
           submitHandler: function(form) {
               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }
               });
   
               var couponapplystatus = $('#scoupon_code').attr('message');
               var getcouponValue = $('#scoupon_code').val();
               if (getcouponValue != '' && couponapplystatus != 1) {
                   alert('Please Press Apply Code Button');
                   return false;
               }
   
               var amount = $('#amountdisplay').attr('finalamount');
               var discount = $('#amountdisplay').attr('coupondiscount');
               var qty = $('#sqty').val();
               var your_name = $('#syour_name').val();
               var receipt_email = $('#sto_email').val();
   
               var coupon_code = $('#scoupon_code').val() || null;
   
               $.ajax({
                   url: '<?php echo e(route('selfgift')); ?>',
                   method: "post",
                   dataType: "json",
                   data: {
                       _token: '<?php echo e(csrf_token()); ?>',
                       amount: amount,
                       discount: discount,
                       qty: qty,
                       your_name: your_name,
                       gift_send_to: receipt_email,
                       user_token: $('#user_token').val(),
                       coupon_code: coupon_code,
                   },
                   success: function(response) {
                       console.log(response.success);
                       if (response.success) {
                           $('#payment').addClass('active');
                           $('#Coupon_error').hide();
                           $('#Coupon_success').html(response.success).show();
                           $('#firstbox').hide();
                           $('#secondbox').hide();
                           $('#paymentdbox').show();
                           $('#paymentresult').html(response.result).show();
                           $('#paymentscript').html(response.paymentscript).show();
                           $("#giftqty").html(qty + ' x $' + (amount / qty) + ' gift card');
                       }
                       if (response.error) {
                           $('#Coupon_success').hide();
                           $('#Coupon_error').html(response.error).show();
                       }
                   }
               });
           }
       });
   
       // Trigger form validation
       if ($("#selfform").valid()) {
           $("#selfform").submit();
       }
   }
   
</script>
<script>
   // Get the current date
   var today = new Date().toISOString().split('T')[0];
   // Set the min attribute of the date input field to today
   document.getElementById('in_future').setAttribute('min', today);
</script>
<script>
   //  Send for Someone Else
   function sendsomeOneElse()
   {
   //  For Validation code 
   $("#someoneform").validate({
          rules: {
   		qty: {
                  required: true,
              },
   		your_name: {
                  required: true,
   			minlength: 3,
              },
   		recipient_name: {
                  required: true,
   			minlength: 3,
              },
   		message: {
   			required: true,
   			minlength: 10,
   			maxlength: 255,
   		},
              gift_send_to: {
                  required: true,
                  email: true,
                  maxlength: 60,
              },
              recipient_email: {
                  required: true,
                  email: true,
                  maxlength: 60,
              },
          },
          messages: {
              qty: {
                  required: "Please select quantity",
              },
              your_name: {
                  required: "Please enter your name",
                  maxlength: "Your name length should be not more than 60 characters long.",
   			minlength: "Please enter at least 3 characters",
              },
              recipient_name: {
                  required: "Recipient name is requires",
                  minlength: "Please enter at least 3 characters",
   			maxlength: "Recipient name length should be not more than 60 characters long.",
              },
   		message: {
                  required: "Message is Required",
                  minlength: "Please enter at least 10 characters",
   			maxlength: "Message length should be not more than 255 characters long.",
              },
   		gift_send_to: {
                  required: "This Fields is required",
   			maxlength: "email length should be not more than 60 characters long.",
              },
   		recipient_email: {
   			required: "This Fields is required",
   			maxlength: "Message length should be not more than 60 characters long.",
              },
          },
   	submitHandler: function(form) {
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
   	var couponapplystatus = $('#coupon_code').attr('message');
   	var getcouponValue = $('#coupon_code').val();
   	if(getcouponValue!='' && couponapplystatus!=1)
   	{
   		alert('Please Press Apply Code Button');
   		return false;										
   	}
   
   	var amount = $('#amountdisplay').attr('finalamount');
   	var discount = $('#amountdisplay').attr('coupondiscount');
   	var qty = $('#qty').val();
   	var gift_send_to = $('#gift_send_to').val();
   	var your_name = $('#your_name').val();
   	var recipient_name = $('#recipient_name').val();
   	var message = $('#message').val();
   	var event = $('#Event_id').val();
   
   	var gift_card_send_type = $('#gift_card_send_type').val();
   	var receipt_email = $('#recipient_email').val();

   	
   	if($('#in_future').val()!='')
   	{
   		var in_future = $('#in_future').val();
   	}
   	else
   	{
   		var in_future = null;
   	}
   	if($('#coupon_code').val()!='')
   	{
   		var coupon_code = $('#coupon_code').val();
   	}
   	else
   	{
   		var coupon_code = null;
   	}
   	
   $.ajax({
   		  url: '<?php echo e(route('sendgift')); ?>',
   		  method: "post",
   		  dataType:"json",
   		  data: {
   			  _token: '<?php echo e(csrf_token()); ?>',
   			  amount:amount,
   			  qty:qty,
   			  your_name:your_name,
   			  recipient_name:recipient_name,
   			  receipt_email:receipt_email,
   			  message:message,
   			  gift_card_send_type:gift_card_send_type,
   			  in_future:in_future,
   			  user_token:$('#user_token').val(),
   			  coupon_code:coupon_code,
   			  discount:discount,
   			  gift_send_to:gift_send_to,
   			  event_id:event,
   		},
   		  success: function (response) {
   			  console.log(response.success);
   			if(response.success)
   		    {
   				$('#payment').addClass('active');
   				$('#Coupon_error').hide();
                  	$('#Coupon_success').html(response.success).show();
   				// nextClick();
          			$('#firstbox').hide(); 
   				$('#secondbox').hide();
   				$('#paymentdbox').show();
   				$('#paymentresult').html(response.result).show();
   				$('#paymentscript').html(response.paymentscript).show();
   				$("#giftqty").html(qty + ' x $' + (amount / qty) + ' gift card');					
   		    }
   			if(response.error)
   		    {
   			$('#Coupon_success').hide();
                  $('#Coupon_error').html(response.error).show();
   		    }
   		    
   		  }
   	   });
   	}
   });
    // Trigger form validation
    if ($("#someoneform").valid()) {
          $("#someoneform").submit();
      }			
   }
   
   // for Coupon Validate 
   $('#Coupon_success').hide();
   $('#Coupon_error').hide();
   
   function CheckCoupon() {
      var amount = $('#amountdisplay').attr('finalamount');
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
   				$("#amountdisplay").attr('coupondiscount', discountAmount);
   				$("#amountdisplay").attr('finalamount', amount);
   			}
   			if(response.data[0]['discount_type']=='percentage')
   			{
   				var discountRate = response.data[0]['discount_rate']; // Assuming discount_rate is a percentage (e.g., 10 for 10%)
   				var discountAmount = (amount * discountRate) / 100;
   				var afterDiscount = amount - discountAmount;
   				$("#amountdisplay").attr('coupondiscount', discountAmount);
   				$("#amountdisplay").attr('finalamount', amount);
   			}
   
   			$("#coupon_code").attr('message', response.data[0]['status']);
              } 
   		if (response.error) {
                  $('#Coupon_success').hide();
                  $('#Coupon_error').html(response.error).show();
   			$("#coupon_code").val('');
   
              } 
          }
      });
   }
   //  for Self
   
   function SelfCoupon() {
      var amount = $('#amountdisplay').attr('finalamount');
      $.ajax({
          url: '<?php echo e(route('coupon-validate')); ?>',
          method: "post",
          dataType: "json",
          data: {
              _token: '<?php echo e(csrf_token()); ?>',
              coupon_code: $('#scoupon_code').val(),
              user_token: $('#user_token').val(),
              amount: amount,
          },
          success: function (response) {
              if (response.success) {
                  $('#SCoupon_error').hide();
                  $('#SCoupon_success').html(response.success).show();
   			if(response.data[0]['discount_type']=='amount')
   			{
   				var discountAmount = response.data[0]['discount_rate'];
   				var afterDiscount = parseInt(amount - discountAmount);
   				$("#amountdisplay").attr('coupondiscount', discountAmount);
   				$("#amountdisplay").attr('finalamount', amount);
   			}
   			if(response.data[0]['discount_type']=='percentage')
   			{
   				var discountRate = response.data[0]['discount_rate']; // Assuming discount_rate is a percentage (e.g., 10 for 10%)
   				var discountAmount = (amount * discountRate) / 100;
   				var afterDiscount = amount - discountAmount;
   				$("#amountdisplay").attr('coupondiscount', discountAmount);
   				$("#amountdisplay").attr('finalamount', amount);
   			}
   			$("#scoupon_code").attr('message', response.data[0]['status']);
              } 
   		if (response.error) {
                  $('#SCoupon_success').hide();
                  $('#SCoupon_error').html(response.error).show();
   			$("#coupon_code").val('');
   
              } 
          }
      });
   }
   
   function check_balance() {
      $.ajax({
          url: '<?php echo e(route('balance-check')); ?>',
          method: "post",
          dataType: "json",
          data: {
              _token: '<?php echo e(csrf_token()); ?>',
              gift_card_number: $('#gift_card_code').val(),
              user_token: $('#user_token').val(),
          },
          success: function (response) {
              if (response.success) {
                  $('.showbalance').html(response.success).show();				
              } 
   		else{
   			$('.showbalance').html(response.error).show();
   		}
          }
      });
   }
   
</script>
<script>
   $(document).ready(function(){
      
   var current_fs, next_fs, previous_fs; //fieldsets
   var opacity;
   
   $(".next").click(function(){
   	
   	current_fs = $(this).parent();
   	next_fs = $(this).parent().next();
   	
   	//Add Class Active
   	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
   	
   	//show the next fieldset
   	next_fs.show(); 
   	//hide the current fieldset with style
   	current_fs.animate({opacity: 0}, {
   		step: function(now) {
   			// for making fielset appear animation
   			opacity = 1 - now;
   
   			current_fs.css({
   				'display': 'none',
   				'position': 'relative'
   			});
   			next_fs.css({'opacity': opacity});
   		}, 
   		duration: 600
   	});
   });
   
   $(".previous").click(function(){
   
   	current_fs = $(this).parent();
   	previous_fs = $(this).parent().prev();
   	
   	//Remove class active
   	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
   	
   	//show the previous fieldset
   	previous_fs.show();
   
   	//hide the current fieldset with style
   	current_fs.animate({opacity: 0}, {
   		step: function(now) {
   			// for making fielset appear animation
   			opacity = 1 - now;
   
   			current_fs.css({
   				'display': 'none',
   				'position': 'relative'
   			});
   			previous_fs.css({'opacity': opacity});
   		}, 
   		duration: 600
   	});
   });
   
   $('.radio-group .radio').click(function(){
   	$(this).parent().find('.radio').removeClass('selected');
   	$(this).addClass('selected');
   });
   
   $(".submit").click(function(){
   	return false;
   })
   	
   });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.front-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\MedsapGiftCardNew\resources\views/pages_for_occasion/christmas.blade.php ENDPATH**/ ?>