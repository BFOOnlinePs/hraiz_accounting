
<?php $__env->startSection('title'); ?>
    فواتير المبيعات
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title'); ?>
    فواتير المبيعات
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_link'); ?>
    الرئيسية
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title_link'); ?>
    فواتير المبيعات
<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.messge_alert.success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.messge_alert.fail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="small-box bg-success text-white border border-success">
                <div class="inner">
                    <div class="row">
                        <div class="col-md-3">
                            <h4 class="text-bold m-1">فواتير مبيعات</h4>
                        </div>
                        <div class="col-md-9">
                            <div class="row ml-2">
                                <a class="btn btn-sm btn-light col-md-3 col-12 m-1 p-2"
                                    href="<?php echo e(route('accounting.sales_invoices.new_invoices_index')); ?>"><span
                                        class="fa fa-plus"></span>&nbsp&nbsp
                                    <span>
                                        فاتورة جديدة
                                    </span>
                                </a>
                                <button type="button" class="btn btn-light btn-sm col-md-3 col-12 m-1 p-2"
                                    data-toggle="modal" data-target="#modal-lg">
                                    <span class="fa fa-file-text"></span>&nbsp&nbsp
                                    <span>
                                        فاتورة من طلبيات بيع
                                    </span>
                                </button>
                                <a class="btn btn-danger btn-sm col-md-3 col-12 m-1 p-2"
                                    href="<?php echo e(route('accounting.sales_invoices.archive_order')); ?>">
                                    <span class="fa fa-trash"></span>&nbsp&nbsp
                                    <span>
                                        ارشيف فواتير البيع
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="card p-3">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">رقم المرجع</label>
                    <input onkeyup="invoice_table_index_ajax()" placeholder="رقم المرجع" id="invoice_reference_number"
                        class="form-control" type="text">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">العميل</label>
                    <select onchange="invoice_table_index_ajax()" class="select2bs4 form-control supplier_select2"
                        name="supplier_id" id="supplier_user_id">
                        <option value="">جميع العملاء</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key->id); ?>"><?php echo e($key->name); ?> | <span>
                                <?php if(in_array("4", json_decode($key->user_role))): ?>
                                    مورد
                                    <?php elseif(in_array("10", json_decode($key->user_role))): ?>
                                    زبون
                                <?php endif; ?>
                            </span></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            
            
            
            
            
            
            
            
            
            
            
            <div class="col">
                <div class="form-group">
                    <label for="">حالة الطلبية</label>
                    <select onchange="invoice_table_index_ajax()" class="form-control" name="order_status"
                        id="invoice_status">
                        <option value="">جميع الحالات ...</option>
                        <option value="stage">مرحل</option>
                        <option value="non_stage">غير مرحل</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">من تاريخ</label>
                    <input onchange="invoice_table_index_ajax()" type='date' id="from_date" class="form-control">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">الى تاريخ</label>
                    <input onchange="invoice_table_index_ajax()" type='date' id="to_date" class="form-control">
                </div>
            </div>
            
            
            
            
            
            
            
            
            
            
            
            
        </div>
    </div>

    <div class="card">

        

        <div class="card-body">
            <div id="invoice_table">

            </div>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        </div>

    </div>
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-xl">
            <form action="<?php echo e(route('accounting.sales_invoices.create_purchase_invoices_from_order')); ?>" method="post"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="text" name="order_id" id="order_input">
                <input type="hidden" name="supplier_user_id" id="supplier_input">
                <input type="hidden" name="invoice_type" value="sales">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">فاتورة من طلبية بيع</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">بحث عن طلبية بيع</label>
                                    <input onkeyup="search_order_ajax()" id="input_search" type="text"
                                        class="form-control" placeholder="بحث عن طلبية بيع">
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">مورد او زبون</label>
                                    <select class="form-control select2bs4" name="supplier_id"
                                        onchange="search_order_ajax()" id="supplier_id">
                                        <option value="">جميع الموردين والزبائن</option>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key->id); ?>"><?php echo e($key->name); ?>

                                                
                                                <span>(</span>
                                                <?php $__currentLoopData = json_decode($key->user_role); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e(\App\Models\UserRole::where('id', $key)->first()->name); ?> ,
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <span>)</span>
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="search_order">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                        
                    </div>

                </div>
            </form>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/plugins/select2/js/select2.full.min.js')); ?>"></script>

    <script>
        function search_order_ajax(page) {

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.sales_invoices.search_order_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'input_search': document.getElementById('input_search').value,
                    'supplier_id': document.getElementById('supplier_id').value,
                    'page': page
                },
                success: function(data) {
                    console.log(data);
                    $('#search_order').html(data.view);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function invoice_table_index_ajax(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.sales_invoices.invoice_table_index_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'supplier_user_id': document.getElementById('supplier_user_id').value,
                    'invoice_reference_number': document.getElementById('invoice_reference_number').value,
                    'page': page,
                    'invoice_status': $('#invoice_status').val(),
                    'from_date': $('#from_date').val(),
                    'to_date': $('#to_date').val(),
                },
                success: function(data) {
                    $('#invoice_table').html(data.view);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }


        window.onload = (event) => {
            search_order_ajax(page);
            invoice_table_index_ajax(page);
        };

        var page = 1;
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            search_order_ajax(page)
            invoice_table_index_ajax(page);
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

<?php echo $__env->make('home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/sales_invoices/index.blade.php ENDPATH**/ ?>