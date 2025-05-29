<div class="modal fade" id="add_orders_sales_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('accounting.orders_sales.create')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h4 class="modal-title">اضافة طلبية بيع</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اسم الزبون</label>
                                <select class="form-control select2bs4" name="user_id" id="">
                                    <option value="">اختر زبون ...</option>
                                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key->id); ?>"><?php echo e($key->name); ?>

                                            <span>(</span>
                                            <?php $__currentLoopData = json_decode($key->user_role); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e(\App\Models\UserRole::where('id', $key)->first()->name); ?> ,
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <span>)</span>
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">الرقم المرجعي</label>
                            <input required type="text" class="form-control" name="reference_number"
                                placeholder="الرقم المرجعي">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-success">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/orders_sales/modals/add_orders_sales.blade.php ENDPATH**/ ?>