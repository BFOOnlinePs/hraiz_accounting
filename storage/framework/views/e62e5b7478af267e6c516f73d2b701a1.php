<table class="w-100 table-bordered text-center table-hover table-striped">
    <thead class="bg-dark">
        <tr>
            
            <td>الرقم المرجعي</td>
            <th>تاريخ الفاتورة</th>
            <th>تاريخ التسليم</th>
            <th>العميل</th>
            <th>المجموع</th>
            <th>الملاحظات</th>
            <th>الحالة</th>
            <th style="width: 130px">العمليات</th>
        </tr>
    </thead>
    <tbody>
        <?php if($data->isEmpty()): ?>
            <tr>
                <td colspan="9" class="text-center">لا توجد بيانات</td>
            </tr>
        <?php else: ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    
                    <td class="text-left"><?php echo e($key->invoice_reference_number); ?></td>
                    <td class="text-left"><?php echo e($key->bill_date); ?></td>
                    <td><?php echo e($key->due_date); ?></td>
                    <td><?php echo e(App\Models\User::where('id', $key->client_id)->value('name')); ?></td>
                    <td><?php echo e($key->totalAmount); ?></td>
                    <td><?php echo e($key->note); ?></td>
                    <td class="text-center">
                        <?php if($key->status == 'stage'): ?>
                            <span class="badge bg-success w-100">مرحل</span>
                        <?php else: ?>
                            <span class="badge bg-danger w-100">غير مرحل</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('accounting.sales_invoices.invoice_view', ['id' => $key->id])); ?>"
                            class="btn btn-dark btn-xs"><span class="fa fa-search"></span></a>
                        <a href="<?php echo e(route('accounting.sales_invoices.edit_invoices', ['id' => $key->id])); ?>"
                            class="btn btn-success btn-xs"><span class="fa fa-edit"></span></a>
                        <?php if($key->status == 'stage'): ?>
                            <button <?php if($key->status == 'stage'): ?> disabled <?php endif; ?>
                                onclick="return confirm('هل تريد حذف البيانات ؟')" class="btn btn-danger btn-xs"><span
                                    class="fa fa-trash"></span></button>
                        <?php else: ?>
                            <a <?php if($key->status == 'stage'): ?> disabled <?php endif; ?>
                                href="<?php echo e(route('accounting.sales_invoices.delete_invoices', ['id' => $key->id])); ?>"
                                onclick="return confirm('هل تريد حذف البيانات ؟')" class="btn btn-danger btn-xs"><span
                                    class="fa fa-trash"></span></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </tbody>
</table>
<?php echo e($data->links()); ?>

<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/sales_invoices/ajax/invoice_table.blade.php ENDPATH**/ ?>