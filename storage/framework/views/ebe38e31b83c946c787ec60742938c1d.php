<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<?php if(\Illuminate\Support\Facades\Session::has('fail')): ?>
    <div class="alert alert-danger"><?php echo e(session('fail')); ?></div>
<?php endif; ?>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/messge_alert/fail.blade.php ENDPATH**/ ?>