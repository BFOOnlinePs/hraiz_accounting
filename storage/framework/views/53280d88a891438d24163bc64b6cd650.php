<table class="w-100 table-hover table-striped table-bordered">
    <thead class="bg-dark">
        <tr>
            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">#
            </th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">الاسم
            </th>
            <th>
                رقم الهاتف
            </th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">البريد الالكتروني
            </th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">حالة الحساب
            </th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">العمليات
            </th>
        </tr>
    </thead>
    <tbody>
        <?php if($data->isEmpty()): ?>
            <tr>
                <td colspan="6" class="text-center">لا توجد نتائج</td>
            </tr>
        <?php endif; ?>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($loop->index + 1); ?></td>
                <td><?php echo e($key->name); ?></td>
                <td><?php echo e($key->user_phone1); ?></td>
                <td><?php echo e($key->email); ?></td>
                <td>
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                        <input <?php if($key->user_status == 1): ?> checked <?php endif; ?> onchange="updateStatus(<?php echo e($key->id); ?>)" type="checkbox" class="custom-control-input" id="customSwitch<?php echo e($key->id); ?>">
                        <label class="custom-control-label" for="customSwitch<?php echo e($key->id); ?>"></label>
                    </div>
                </td>
                <td>
                    <a class="btn btn-dark btn-sm" href="<?php echo e(route('users.employees.details', ['id' => $key->id])); ?>"><span class="fa fa-search"></span></a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/hr/employees/ajax/employee_table.blade.php ENDPATH**/ ?>