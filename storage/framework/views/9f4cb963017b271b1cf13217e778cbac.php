
<?php $__env->startSection('title'); ?>
    كشف حساب زبون
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title'); ?>
    كشف حساب زبون
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_link'); ?>
    الرئيسية
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title_link'); ?>
    كشف حساب زبون
<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.messge_alert.success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.messge_alert.fail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <input type="hidden" id="user_type" value="customer">
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <input onkeyup="list_customers_table()" type="text" class="form-control" id="search_input"
                            placeholder="البحث عن زبون">
                    </div>
                </div>
                <div class="col-md-3 text-center d-flex">
                    <div class="custom-control custom-radio">
                        <input onchange="list_customers_table()" class="custom-control-input radio_button_user"
                            value="" type="radio" id="customRadio0" name="customRadio" checked>
                        <label for="customRadio0" class="custom-control-label">الجميع</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input onchange="list_customers_table()" class="custom-control-input radio_button_user"
                            value="supplier" type="radio" id="customRadio1" name="customRadio">
                        <label for="customRadio1" class="custom-control-label">مورد</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input onchange="list_customers_table()" class="custom-control-input radio_button_user"
                            value="customer" type="radio" id="customRadio2" name="customRadio">
                        <label for="customRadio2" class="custom-control-label">زبون</label>
                    </div>
                    
                    
                    
                    
                    
                    
                    
                    
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="list_customers_table">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/plugins/select2/js/select2.full.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            list_customers_table(1);
        });

        function list_customers_table(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.account-statement.list_customers_table_ajax')); ?>',
                method: 'POST',
                header: headers,
                data: {
                    'radio_user': $('.radio_button_user:checked').val(),
                    'search_input': $('#search_input').val(),
                    'user_type': $('#user_type').val(),
                    '_token': csrfToken,
                    'page': page
                },
                success: function(data) {
                    $('#list_customers_table').html(data.view);
                    console.log(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);
                }
            });
        }

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            list_customers_table(page)
        });
    </script>
    <script>
        $(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/account_statement/customer_account_statement_index.blade.php ENDPATH**/ ?>