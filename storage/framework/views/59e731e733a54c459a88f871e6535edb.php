<table class="table table-sm table-striped table-hover">
    <thead>
        <tr>
            <th></th>
            <th>الباركود</th>
            <th>الصنف</th>
            <th>الكمية</th>
            <th>السعر</th>
            <?php if(
                $order_items->order_status == 'invoice_has_not_been_posted' &&
                    in_array('1', json_decode(auth()->user()->user_role))): ?>
                <th>العمليات</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php if($data->isEmpty()): ?>
            <tr>
                <td colspan="5" class="text-center">لا توجد اصناف</td>
            </tr>
        <?php else: ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><input name="select_items[]" value="<?php echo e($key->id); ?>" checked type="checkbox"></td>
                    <td><?php echo e($key->product->barcode); ?></td>
                    <td><?php echo e($key->product->product_name_ar); ?></td>
                    <td><input <?php if($order_items->order_status == 'invoice_has_been_posted' || in_array('11', json_decode(auth()->user()->user_role))): ?> disabled <?php endif; ?> type="number"
                            onchange="update_orders_sales_items(<?php echo e($key->id); ?> ,'qty',this.value)"
                            class="form-control" value="<?php echo e($key->qty); ?>"></td>
                    <td><input <?php if($order_items->order_status == 'invoice_has_been_posted' || in_array('11', json_decode(auth()->user()->user_role))): ?> disabled <?php endif; ?> type="number"
                            onchange="update_orders_sales_items(<?php echo e($key->id); ?>,'price',this.value)"
                            class="form-control" value="<?php echo e($key->price); ?>"></td>
                    <?php if(
                        $order_items->order_status == 'invoice_has_not_been_posted' &&
                            in_array('1', json_decode(auth()->user()->user_role))): ?>
                        <td>
                            <button class="btn btn-danger btn-sm"
                                onclick="delete_orders_sales_items(<?php echo e($key->id); ?>)"><span
                                    class="fa fa-close"></span></button>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </tbody>
</table>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/orders_sales/ajax/sales_price_select_items.blade.php ENDPATH**/ ?>