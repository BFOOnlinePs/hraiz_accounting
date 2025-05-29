<table class="w-100 text-center table-hover table-bordered table-striped">
    <thead class="bg-dark">
        <tr>
            <th style="width: 17%">تاريخ الاضافة</th>
            <th style="width: 17%">الزبون</th>
            <th style="width: 17%">بواسطة</th>
            <th >ملاحظات</th>
            <th style="width: 100px">العملة</th>
            <th style="width: 100px"></th>
        </tr>
    </thead>
    <tbody>
        <?php if(!$data->isEmpty()): ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key->insert_at); ?></td>
                    <td><?php echo e($key->user->name); ?></td>
                    <td><?php echo e($key->insert_by_user->name); ?></td>
                    <td><?php echo e($key->notes); ?></td>
                    <td><?php echo e($key->currency->currency_name); ?></td>
                    <td>
                        <a href="<?php echo e(route('price_offer_sales.price_offer_sales_items.price_offer_sales_items_index', ['id' => $key->id])); ?>"
                            class="btn btn-dark btn-xs"><span class="fa fa-search"></span></a>
                        <a class="btn btn-danger btn-xs" href="<?php echo e(route('price_offer_sales.archive.add_to_archive',['id'=>$key->id])); ?>"><span class="fa fa-trash"></span></a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">لا توجد بيانات</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/sales/price_offer_sales/ajax/price_offer_sales_table.blade.php ENDPATH**/ ?>