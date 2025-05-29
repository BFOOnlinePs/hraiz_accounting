<table class="table table-sm table-bordered" style="width: 100%">
    <tr>
        <th></th>
        <th>اسم العنصر</th>
    </tr>
    <?php if(!$data->isEmpty()): ?>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <input type="hidden" id="item_id_<?php echo e($key->id); ?>" value="<?php echo e($key->id); ?>">
        <td><input onchange="create_product_ajax(<?php echo e($key->id); ?>)" type="checkbox"></td>
        <td><?php echo e($key->product_name_ar); ?></td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <tr>
            <td class="text-center" colspan="2">لا توجد بيانات</td>
        </tr>
    <?php endif; ?>


</table>
<?php echo e($data->links()); ?>

<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/sales_invoices/invoices/ajax/search_product.blade.php ENDPATH**/ ?>