
<?php $__env->startSection('title'); ?>
    تفاصيل طلبية البيع
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title'); ?>
    تفاصيل طلبية البيع
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_link'); ?>
    الرئيسية
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title_link'); ?>
    تفاصيل طلبية البيع
<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.messge_alert.success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.messge_alert.fail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-dark" <?php if($data->order_status == 'invoice_has_been_posted'): ?> disabled <?php endif; ?>
                onclick="open_add_product_modal()">اضافة اصناف</button>
            
            <button type="button" onclick="order_sales_select_item_ajax()" class="btn btn-secondary"
                <?php if($data->order_status == 'invoice_has_been_posted'): ?> disabled <?php endif; ?>>انشاء
                فاتورة من
                طلبية البيع</button>

            
            
            <button class="btn btn-warning float-right" data-toggle="modal" data-target="#order_sales_print_modal"><span
                    class="fa fa-print"></span></button>
            <button class="btn btn-dark mr-1 float-right" data-toggle="modal" data-target="#add_preparation_modal">ارسال الى
                التحضير</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php if($data->order_status == 'invoice_has_been_posted'): ?>
                        <div class="alert alert-success text-center">
                            تم ترحيل طلبية البيع بنجاح
                        </div>
                    <?php endif; ?>
                    
                    <?php if(empty($data->price_offer_sales_id)): ?>
                        <div class="row text-center">
                            <div class="col-md-12 alert alert-info">
                                تم انشاء طلبية البيع استناداً لعرض سعر رقم <a
                                    href="<?php echo e(route('price_offer_sales.price_offer_sales_items.price_offer_sales_items_index', ['id' => $data->price_offer_sales_id])); ?>"
                                    target="_blank" class="btn btn-dark btn-sm"><?php echo e($data->price_offer_sales_id); ?></a> وتم
                                اضافة التاريخ بشكل تلقائي
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="from-group">
                                        <label for="">الرقم المرجعي لطلبية البيع</label>
                                        <input <?php if($data->order_status == 'invoice_has_been_posted'): ?> disabled <?php endif; ?> type="text"
                                            onchange="update_orders_sales(<?php echo e($data->id); ?>,'reference_number',this.value)"
                                            class="form-control" value="<?php echo e($data->reference_number); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">العميل</label>
                                        <select disabled name="client_id" id="" class="form-control select2bs4">
                                            <option value="">اختر عميل ...</option>
                                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php if($key->id == $data->user_id): ?> selected <?php endif; ?>
                                                    value="<?php echo e($key->id); ?>"><?php echo e($key->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">تاريخ اصدار طلبية البيع</label>
                                        <input type="date" <?php if($data->order_status == 'invoice_has_been_posted'): ?> disabled <?php endif; ?>
                                            class="form-control"
                                            onchange="update_orders_sales(<?php echo e($data->id); ?>,'inserted_at',this.value)"
                                            value="<?php echo e($data->inserted_at); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">حالة الطلبية</label>
                                        <select name="" onchange="update_order_sales_status_ajax(this.value)"
                                            id="" class="form-control select2bs4">
                                            <option <?php if($data->order_status == 'new'): ?> selected <?php endif; ?> value="new">جديدة
                                            </option>
                                            <option <?php if($data->order_status == 'invoice_send_preparation'): ?> selected <?php endif; ?>
                                                value="invoice_send_preparation">
                                                تم
                                                ارسالها الى التحضير</option>
                                            <option <?php if($data->order_status == 'pending'): ?> selected <?php endif; ?> value="pending">قيد
                                                الانتظار
                                            </option>
                                            <option <?php if($data->order_status == 'ready'): ?> selected <?php endif; ?> value="ready">جاهزة
                                            </option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="list_product_details">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('admin.accounting.orders_sales.modals.add_product_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.accounting.orders_sales.modals.order_sales_print_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.accounting.orders_sales.modals.add_preparation_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.accounting.orders_sales.modals.add_orders_sales', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.accounting.orders_sales.modals.create_order_from_order_sales', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/plugins/select2/js/select2.full.min.js')); ?>"></script>

    <script>
        $(document).ready(function() {
            orders_sales_items_list_ajax(1);
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            product_list_ajax(page);
        });

        function product_list_ajax(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.orders_sales.product_list_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'page': page,
                    'search': $('#product_search').val()
                },
                success: function(data) {
                    $('#product_list_table').html(data.view)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function orders_sales_items_list_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.orders_sales.orders_sales_items_list_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': <?php echo e($data->id); ?>

                },
                success: function(data) {
                    $('#list_product_details').html(data.view)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function create_orders_sales_items(product_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.orders_sales.create_orders_sales_items')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': <?php echo e($data->id); ?>,
                    'product_id': product_id,
                },
                success: function(data) {
                    orders_sales_items_list_ajax();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_orders_sales_items(id, key, value) {
            if (!id || !key || value === undefined || value === null || value === '') {
                alert('يجب إدخال مدخل صحيح');
                return;
            }
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.orders_sales.update_orders_sales_items')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'key': key,
                    'value': value,
                },
                success: function(data) {

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('حدث خطا اثناء المعالجة');
                }
            });
        }

        function update_orders_sales(id, key, value) {
            if (!id || !key || value === undefined || value === null || value === '') {
                alert('يجب إدخال مدخل صحيح');
                return;
            }
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.orders_sales.update_orders_sales')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'key': key,
                    'value': value,
                },
                success: function(data) {

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('حدث خطا اثناء المعالجة');
                }
            });
        }

        function delete_orders_sales_items(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.orders_sales.delete_orders_sales_items')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                },
                success: function(data) {
                    orders_sales_items_list_ajax();
                    // order_sales_select_item_ajax()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function add_price_offer_sales_to_order_sales() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.orders_sales.add_price_offer_sales_to_order_sales')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    price_offer_sales_id: <?php echo e($data->id); ?>,
                    customer_id: <?php echo e($data->user_id); ?>,
                },
                success: function(response) {
                    window.location.href
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function open_add_product_modal() {
            $('#add_product_modal').modal('show');
            product_list_ajax();
        }

        function post_the_invoice() {
            window.location.href = '<?php echo route('accounting.orders_sales.orders_sales_details', ['order_id' => $data->id]); ?>'
        }

        function order_sales_select_item_ajax() {
            $('#create_order_from_order_sales').modal('show');

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.orders_sales.order_sales_select_item_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': <?php echo e($data->id); ?>

                },
                success: function(data) {
                    $('#order_sales_list').html(data.view)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        $('input[name="radio_button"]').change(function() {
            if ($('#print_qr').is(':checked')) {
                list_order_sales_product_for_qr();
            } else {
                $('#list_order_sales_product_for_qr').html('');
            }
        });

        function list_order_sales_product_for_qr() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.orders_sales.list_order_sales_product_for_qr')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': <?php echo e($data->id); ?>

                },
                success: function(data) {
                    $('#list_order_sales_product_for_qr').html(data.view)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_order_sales_status_ajax(order_status) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.orders_sales.update_order_sales_status_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    order_id: <?php echo e($data->id); ?>,
                    order_status: order_status
                },
                success: function(data) {},
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

<?php echo $__env->make('home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/orders_sales/orders_sales_details.blade.php ENDPATH**/ ?>