<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th>باركود الصنف</th>
            <th>الصنف</th>
            <th>السعر</th>
        </tr>
    </thead>
    <tbody>
        <?php if($data->isEmpty()): ?>
            <tr>
                <td colspan="3" class="text-center">لا توجد اصناف</td>
            </tr>
        <?php else: ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key->product->barcode); ?></td>
                    <td><?php echo e($key->product->product_name_ar); ?></td>
                    <td><?php echo e($key->price); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </tbody>
</table>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/sales/price_offer_sales/price_offer_sales_items/ajax/price_offer_sales_product_table_found.blade.php ENDPATH**/ ?>