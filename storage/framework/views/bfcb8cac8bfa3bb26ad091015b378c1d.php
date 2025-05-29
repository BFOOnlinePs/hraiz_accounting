<div class="modal fade" id="add_preparation_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo e(route('accounting.orders_sales.create_preparation')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="order_id" value="<?php echo e($data->id); ?>">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة الطلبية للتحضير</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اختر موظف</label>
                                <select required class="select2bs4 form-control" name="employee_id" id="">
                                    <option value="">اختر موظف ...</option>
                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key->id); ?>"><?php echo e($key->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">ملاحظات</label>
                                <textarea name="notes" id="" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">ارسال الى التحضير</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/orders_sales/modals/add_preparation_modal.blade.php ENDPATH**/ ?>