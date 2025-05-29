<table style="width: 100%" class="table table-sm table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 10px">#</th>
            <th style="width: 150px">اسم العميل</th>
            <th>تاريخ الاضافة</th>
            <th style="width: 120px">ملاحظات</th>
            <th style="width: 120px">العملة</th>
            <th>عروض الاسعار</th>
            <th style="width: 350px"></th>
        </tr>
    </thead>
    <tbody>
        <?php if(!$data->isEmpty()): ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($loop->index + 1); ?></td>
                    <td><?php echo e($key['client']->name); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($key->inserted_at)->toDateString()); ?></td>

                    <td><?php echo e($key->notes); ?></td>
                    <td><?php echo e($key->currency->currency_name ?? ''); ?></td>
                    <td>
                        <?php $__currentLoopData = $key->price_offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price_offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a style="display: inline"
                                href="<?php echo e(route('accounting.sales_invoices.invoice_view', ['id' => $price_offer->id])); ?>"><?php echo e($price_offer->created_at); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td>
                        <?php echo e($key->id); ?>

                        <button onclick="get_order_id(<?php echo e($key->id); ?>,<?php echo e($key->client->id); ?>)" type="submit"
                            class="btn btn-success btn-sm"><span class="fa fa-check"></span>&nbsp; انشاء فاتورة من طلبية
                            بيع</button>
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

<script>
    function get_order_id(id, supplier_id) {
        document.getElementById('order_input').value = id;
        document.getElementById('supplier_input').value = supplier_id;
    }
</script>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/sales_invoices/ajax/search_order.blade.php ENDPATH**/ ?>