<div class="modal fade" id="create_price_offer_sales_modal">
    <div class="modal-dialog">
        <form action="<?php echo e(route('price_offer_sales.create')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة عرض سعر بيع</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اسم الزبون</label>
                                <select required class="form-control select2bs4" name="customer_id" id="">
                                    <option value="">اختر زبون ...</option>
                                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key->id); ?>"><span class="bg-danger">
                                                <?php if(in_array(4, json_decode($key->user_role))): ?>
                                                    مورد |
                                                    <span>
                                                        <?php echo e($key->name); ?>

                                                    </span>
                                                <?php else: ?>
                                                    زبون |
                                                    <span>
                                                        <?php echo e($key->name); ?>

                                                    </span>
                                                <?php endif; ?>
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">العملة</label>
                                <select class="form-control select2bs4" name="currency_id" id="">
                                    <?php $__currentLoopData = $currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key->id); ?>"><?php echo e($key->currency_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الملاحظات</label>
                                <textarea class="form-control" name="notes" id="" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-dark">انشاء عرض سعر بيع</button>
                </div>

            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/sales/price_offer_sales/modals/create_price_offer_sales.blade.php ENDPATH**/ ?>