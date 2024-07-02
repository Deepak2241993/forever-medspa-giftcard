
<?php $__env->startSection('body'); ?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Product List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                        Product
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
            <a href="<?php echo e(route('product.create')); ?>" class="btn btn-primary">Add More</a>
            <div class="card-header">
               
               <span class="text-success"> <?php if(session()->has('success')): ?>
                    <?php echo e(session()->get('success')); ?>

                <?php endif; ?></span>
            </div>
           
            <?php if($data['status']==200): ?>
            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th>Product Description</th>
                    <th>Created At</th>
                    <th>Action</th>
                   
                   </tr>
                </thead>
                 <tbody>
                    <?php $__currentLoopData = $data['result']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($value['product_name'] ? $value['product_name']:'NULL'); ?></td>
                        <td><img src="<?php echo e($value['product_image']); ?>" style="height:100px; width:100px;"></td>
                        <td><?php echo mb_strimwidth(isset($value['product_description']) ? $value['product_description'] : 'NULL', 0, 200, '...'); ?></td>


                       
                        <td><?php echo e(date('m-d-Y h:i:s',strtotime($value['created_at']))); ?></td>
                        <td>
                            <a href="<?php echo e(route('product.edit',$value['id'])); ?>" class="btn btn-primary">Edit</a>
                            <form action="<?php echo e(route('product.destroy',$value['id'])); ?>" method="POST">
                                <?php echo method_field('DELETE'); ?>
                                <?php echo csrf_field(); ?> <!-- Include CSRF token for security -->
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                       
                        
                        <!-- Button trigger modal -->

  

                       
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php else: ?>
           <p class="text-danger"> <?php echo e(($data['error'])); ?></p>
            <?php endif; ?>
            <!--end::Row-->               
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>


  <!-- Modal -->
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
      
<script>

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




    </script>
    
  <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\MedsapGiftCardNew\resources\views/admin/product/product_index.blade.php ENDPATH**/ ?>