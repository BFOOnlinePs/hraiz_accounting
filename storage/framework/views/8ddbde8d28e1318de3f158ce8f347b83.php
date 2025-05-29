<table class="table table-sm table-hover border-bottom">
    <thead>
        <tr>
            <th style="width: 30px"></th>
            <th>اسم الصنف</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!$data->isEmpty()): ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <input onchange="create_price_offer_sales_items_ajax(<?php echo e($key->id); ?>)" type="checkbox">
                    </td>
                    <td><?php echo e($key->barcode); ?></span> | <span><?php echo e($key->product_name_ar); ?></span></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <tr>
                <td colspan="2" class="text-center">لا توجد نتائج</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php echo e($data->links()); ?>

<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/sales/price_offer_sales/price_offer_sales_items/ajax/product_list_search.blade.php ENDPATH**/ ?>