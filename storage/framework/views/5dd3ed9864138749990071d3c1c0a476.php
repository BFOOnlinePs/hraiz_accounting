<table class="w-100 table-striped table-hover table-bordered">
    <thead class="bg-dark">
        <tr>
            <th>الباركود</th>
            <th>الصنف</th>
            <th style="width: 10%">الكمية</th>
            <th style="width: 10%">السعر</th>
            <?php if(
                $order_items->order_status == 'invoice_has_not_been_posted' &&
                    in_array('1', json_decode(auth()->user()->user_role))): ?>
                <th style="width: 100px" class="text-center">العمليات</th>
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
                    <td><?php echo e($key->product->barcode); ?></td>
                    <td><?php echo e($key->product->product_name_ar); ?></td>
                    <td><input pattern="[0-9]+" title="please enter number only" tabindex="<?php echo e($loop->index + 1); ?>"
                            <?php if($order_items->order_status == 'invoice_has_been_posted' || in_array('11', json_decode(auth()->user()->user_role))): ?> disabled <?php endif; ?> type="text"
                            onchange="update_orders_sales_items(<?php echo e($key->id); ?> ,'qty',this.value)"
                            class="" value="<?php echo e($key->qty); ?>"></td>
                    <td>
                        <input pattern="[0-9]+" title="please enter number only"
                            <?php if($order_items->order_status == 'invoice_has_been_posted' || in_array('11', json_decode(auth()->user()->user_role))): ?> disabled <?php endif; ?> type="text"
                            onchange="update_orders_sales_items(<?php echo e($key->id); ?>,'price',this.value)"
                            class="" value="<?php echo e($key->price); ?>">
                    </td>
                    <?php if(
                        $order_items->order_status == 'invoice_has_not_been_posted' &&
                            in_array('1', json_decode(auth()->user()->user_role))): ?>
                        <td class="text-center">
                            <button class="btn btn-danger btn-xs"
                                onclick="delete_orders_sales_items(<?php echo e($key->id); ?>)"><span
                                    class="fa fa-close"></span></button>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </tbody>
</table>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/orders_sales/ajax/list_product_details.blade.php ENDPATH**/ ?>