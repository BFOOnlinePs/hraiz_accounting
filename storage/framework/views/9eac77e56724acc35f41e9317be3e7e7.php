<table class="table table-hover table-bordered table-sm">
    <thead>
        <tr>
            <th style="width: 7%"></th>
            <th>اسم الزبون</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if($data->isEmpty()): ?>
            <tr>
                <td colspan="3" class="text-center">لا توجد نتائج</td>
            </tr>
        <?php else: ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <?php if(in_array(4, json_decode($key->user_role))): ?>
                            <span class="badge badge-warning w-100">مورد</span>
                        <?php elseif(in_array(10, json_decode($key->user_role))): ?>
                            <span class="badge badge-info w-100">زبون</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($key->name); ?></td>
                    <td>
                        <a href="<?php echo e(route('accounting.account-statement.account_statement_details', ['id' => $key->id, 'user_type' => 'customer'])); ?>"
                            class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </tbody>
</table>
<?php echo e($data->links()); ?>

<script>
    
    
    

    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</script>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/account_statement/ajax/list_customers_table.blade.php ENDPATH**/ ?>