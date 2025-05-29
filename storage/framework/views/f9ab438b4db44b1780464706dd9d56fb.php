
<?php $__env->startSection('title'); ?>
    الموظفين
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title'); ?>
    الموظفين
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_link'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title_link'); ?>
    الموظفين
<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/toastr/toastr.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.messge_alert.success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.messge_alert.fail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">قائمة الموظفين</h3>
                </div>
                <div class="card-body">
                    <div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <input type="text" onkeyup="employee_table()" class="form-control" id="search" placeholder="بحث">
                                    </div>
                                </div>
                                <div id="employee_table">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-2">
            <div class="row">
                <div class="col-md-12">
                    <a href="<?php echo e(route('users.employees.add')); ?>" class="btn form-control btn-dark mb-2">إضافة موظف</a>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="form-group">
                        <a href="<?php echo e(route('users.procurement_officer.index')); ?>" class="btn btn-sm btn-warning form-control">موظف المشتريات</a>
                    </div>
                    <div class="form-group">
                        <a href="<?php echo e(route('users.storekeeper.index')); ?>" class="btn btn-sm btn-warning form-control">أمين المستودع</a>
                    </div>
                    <div class="form-group">
                        <a href="<?php echo e(route('users.secretarial.index')); ?>" class="btn btn-sm btn-warning form-control">سكرتيريا</a>
                    </div>
                    <div class="form-group">
                        <a href="<?php echo e(route('users.supplier.index')); ?>" class="btn btn-sm btn-warning form-control">الموردين</a>
                    </div>
                    <div class="form-group">
                        <a href="<?php echo e(route('users.delivery_company.index')); ?>" class="btn btn-sm btn-warning form-control">شركات الشحن</a>
                    </div>
                    <div class="form-group">
                        <a href="<?php echo e(route('users.clearance_companies.index')); ?>" class="btn btn-sm btn-warning form-control">شركات التخليص</a>
                    </div>
                    <div class="form-group">
                        <a href="<?php echo e(route('users.local_carriers.index')); ?>" class="btn btn-sm btn-warning form-control">شركات النقل المحلي</a>
                    </div>
                    <div class="form-group">
                        <a href="<?php echo e(route('users.insurance_companies.index')); ?>" class="btn btn-sm btn-warning form-control">شركات التأمين</a>
                    </div>
                    <div class="form-group">
                        <a href="<?php echo e(route('users.clients.index')); ?>" class="btn btn-sm btn-warning form-control">زبائن</a>
                    </div>
                    <div class="form-group">
                        <a href="<?php echo e(route('users.employees.index')); ?>" class="btn btn-sm btn-warning form-control">موظفين</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('assets/plugins/toastr/toastr.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            employee_table();
        });
        function updateStatus(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: "<?php echo e(url('users/updateStatus')); ?>",
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'user_status': document.getElementById('customSwitch' + id).checked
                },
                success: function(data) {
                    toastr.success('تم تعديل الحالة بنجاح');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                }
            });
        }
        function employee_table() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: "<?php echo e(route('users.employees.employee_table')); ?>",
                method: 'post',
                headers: headers,
                data: {
                    'search': document.getElementById('search').value
                },
                success: function(data) {
                    $('#employee_table').html(data.view);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/hr/employees/index.blade.php ENDPATH**/ ?>