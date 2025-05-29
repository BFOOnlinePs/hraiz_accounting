
<?php $__env->startSection('title'); ?>
    عروض اسعار البيع
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title'); ?>
    عروض اسعار البيع
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_link'); ?>
    الرئيسية
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title_link'); ?>
    عروض اسعار البيع
<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/toastr/toastr.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.messge_alert.success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.messge_alert.fail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="small-box bg-dark text-white border border-dark">
                <div class="inner">
                    <div class="row">
                        <div class="col-md-3">
                            <h4 class="text-bold m-1">عروض اسعار البيع</h4>
                        </div>
                        <div class="col-md-9">
                            <div class="row ml-2 w-100">
                                <button type="button" class="btn btn-light btn-sm col-md-3 col-12 m-1 p-2"
                                    data-toggle="modal" data-target="#create_price_offer_sales_modal">
                                    <span class="fa fa-plus"></span>
                                    &nbsp;
                                    &nbsp;
                                    <span>اضافة عرض سعر بيع</span>
                                </button>
                                <a href="<?php echo e(route('price_offer_sales.archive.archive_index')); ?>" class="btn btn-danger btn-sm col-md-3 col-12 m-1 p-2">
                                    <span class="fa fa-trash"></span>
                                    &nbsp;
                                    &nbsp;
                                    <span>ارشيف عروض الاسعار</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">الزبون</label>
                        <select onchange="price_offer_sales_table_ajax()" class="form-control select2bs4" name=""
                            id="customer_id">
                            <option value="">الكل</option>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(in_array(4, json_decode($key->user_role))): ?>
                                    مورد |
                                    <span>
                                        <?php echo e($key->name); ?>

                                    </span>
                                <?php elseif(in_array(10, json_decode($key->user_role))): ?>
                                    زبون |
                                    <span>
                                        <?php echo e($key->name); ?>

                                    </span>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">تمت الاضافة بواسطة</label>
                        <select onchange="price_offer_sales_table_ajax()" class="form-control select2bs4" name=""
                            id="insert_by">
                            <option value="">الكل</option>
                            <?php $__currentLoopData = $added_by; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key->id); ?>"><?php echo e($key->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">من</label>
                                <input onchange="price_offer_sales_table_ajax()" type="date" id="from"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">الى</label>
                                <input onchange="price_offer_sales_table_ajax()" type="date" id="to"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="price_offer_sales_table">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('admin.sales.price_offer_sales.modals.create_price_offer_sales', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/plugins/select2/js/select2.full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/toastr/toastr.min.js')); ?>"></script>

    <script>
        $(document).ready(function() {
            price_offer_sales_table_ajax();
        });

        function price_offer_sales_table_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('price_offer_sales_table').innerHTML =
                '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '<?php echo e(route('price_offer_sales.price_offer_sales_table_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'customer_id': document.getElementById('customer_id').value,
                    'insert_by': document.getElementById('insert_by').value,
                    'from': document.getElementById('from').value,
                    'to': document.getElementById('to').value,
                },
                success: function(data) {
                    if (data.success == 'true') {
                        $('#price_offer_sales_table').html(data.view);
                    } else if (data.success == 'false') {
                        toastr.error(data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
    </script>
    <script>
        $(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/sales/price_offer_sales/index.blade.php ENDPATH**/ ?>