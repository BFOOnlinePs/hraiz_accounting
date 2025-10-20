
<?php $__env->startSection('title'); ?>
    اصناف عروض اسعار البيع
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title'); ?>
    اصناف عروض اسعار البيع
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_link'); ?>
    الرئيسية
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title_link'); ?>
    اصناف عروض اسعار البيع
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
        <div class="col-md-12">
            <h4>عرض سعر بيع</h4>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">

                            <div style="display: flex; gap: 10px; align-content:center; justify-content:start">
                                <span class="justify-content-center align-content-center">
                                    السادة :
                                </span>
                                <select style="width: 500px" name="" id=""
                                    onchange="update_customer_ajax(this.value)" class="form-control select2bs4"
                                    style="display: inline">
                                    <?php $__currentLoopData = $client; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if($price_offer_sales->customer_id == $key->id): ?> selected <?php endif; ?>
                                            value="<?php echo e($key->id); ?>">
                                            <?php echo e($key->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div style="display: flex; gap: 10px; align-content:center; justify-content:start">
                                <span class="justify-content-center align-content-center">
                                    العملة :
                                </span>
                                <select
                                    onchange="update_currency_notes_customer_for_price_offer_sales_items_ajax(this.value,'currency')"
                                    style="width: 500px" name="" id="" class="form-control select2bs4"
                                    style="display: inline" name="" id="">
                                    <?php $__currentLoopData = $currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if($key->id == $price_offer_sales->currency_id): ?> selected <?php endif; ?>
                                            value="<?php echo e($key->id); ?>"><?php echo e($key->currency_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-dark" style="float: left" data-toggle="modal"
                        data-target="#language_print_pdf"><span class="fa fa-print"></span></button>
                    <button class="btn btn-warning mr-2" id="add_price_offer_sales_button" style="float: left">اضافة طلبية
                        بيع من عرض السعر هذا</button>
                    


                </div>
                <div class="col-md-12">
                    <div class="form-group mt-3">
                        <button type="button" class="btn btn-info mb-2" onclick="show_form_product()">اضافة صنف
                        </button>

                    </div>

                </div>

                
                
                
            </div>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="price_offer_sales_items_table">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">الملاحظات</label>
                        <textarea onchange="update_currency_notes_customer_for_price_offer_sales_items_ajax(this.value,'notes')"
                            class="form-control" name="" id="" cols="30" rows="3"><?php echo e($price_offer_sales->notes); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="language_print_pdf">
        <div class="modal-dialog modal-default">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">طباعة عرض سعر بيع</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('price_offer_sales.price_offer_sales_items.price_offer_sales_items_pdf')); ?>"
                        method="post">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo e($price_offer_sales->id); ?>">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="">اختر اللغة</label>
                                <select class="form-control" required name="language" id="">
                                    <option value="">اختر لغة ...</option>
                                    <option value="ar">عربي</option>
                                    <option value="en">انجليزي</option>
                                    <option value="he">عبري</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-2">عرض</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('admin.sales.price_offer_sales.price_offer_sales_items.modals.product_search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.sales.price_offer_sales.price_offer_sales_items.modals.price_offer_found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/plugins/select2/js/select2.full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/toastr/toastr.min.js')); ?>"></script>

    <script>
        $(document).ready(function() {
            document.getElementById('form_product').style.display = 'none';
            product_list_search(page);
            price_offer_sales_items_table_ajax(page);
            $('#currency_id').val(<?php echo e($price_offer_sales->currency_id); ?>);
        });

        function show_form_product() {
            document.getElementById('form_product').classList.add('show');
            document.getElementById('form_product').style.display = 'block';
            setTimeout(function() {
                $('#product_search').focus();
            }, 200);
        }

        function close_form_product() {
            document.getElementById('form_product').classList.remove('show');
            document.getElementById('form_product').style.display = 'none';
        }

        function product_list_search(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('price_offer_sales.price_offer_sales_items.product_list_search')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'price_offer_sales_id': <?php echo e($price_offer_sales->id); ?>,
                    'product_search': document.getElementById('product_search').value,
                    'page': page
                },
                success: function(data) {
                    $('#product_list_search').html(data.view);
                    // toastr.success('تم تعديل الوحدة بنجاح')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function price_offer_sales_items_table_ajax(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('price_offer_sales.price_offer_sales_items.price_offer_sales_items_table_ajax')); ?>',
                method: 'post',
                method: 'post',
                headers: headers,
                data: {
                    'price_offer_sales_id': <?php echo e($price_offer_sales->id); ?>,
                    'page': page,
                },
                success: function(data) {
                    $('#price_offer_sales_items_table').html(data.view)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function create_price_offer_sales_items_ajax(product_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('price_offer_sales_items_table').innerHTML =
                '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '<?php echo e(route('price_offer_sales.price_offer_sales_items.create_price_offer_sales_items_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'price_offer_sales_id': <?php echo e($price_offer_sales->id); ?>,
                    'product_id': product_id,
                },
                success: function(data) {
                    if (data.success == 'true') {
                        toastr.success(data.message);
                        product_list_search(page);
                        price_offer_sales_items_table_ajax(page);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function delete_price_offer_sales_items(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('price_offer_sales_items_table').innerHTML =
                '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '<?php echo e(route('price_offer_sales.price_offer_sales_items.delete_price_offer_sales_items')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                },
                success: function(data) {
                    console.log(data);
                    if (data.success == 'true') {
                        toastr.success(data.message);
                        product_list_search(page);
                        price_offer_sales_items_table_ajax(page)
                    } else if (data.success == 'false') {
                        toastr.error(data.message);
                        product_list_search(page);
                        price_offer_sales_items_table_ajax(page)
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        $('#add_price_offer_sales_button').click(function() {
            check_price_offer_sales_if_found(function(response) {
                if (response.status === 'not_empty') {
                    get_price_offer_sales_table_for_order_items();
                } else {
                    add_price_offer_sales_to_order_sales(<?php echo e($price_offer_sales->id); ?>)
                }
            });
        })

        function get_price_offer_sales_table_for_order_items() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('price_offer_sales.price_offer_sales_items_table_display_for_order_sales')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'price_offer_sales_id': <?php echo e($price_offer_sales->id); ?>

                },
                success: function(data) {
                    $('#price_offer_found_modal').modal('show');
                    $('#price_offer_sales_product_table').html(data.view);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function check_price_offer_sales_if_found(callback) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.orders_sales.check_if_price_offer_if_found')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'price_offer_sales_id': <?php echo e($price_offer_sales->id); ?>

                },
                success: function(data) {
                    callback(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function add_price_offer_sales_to_order_sales(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.orders_sales.add_price_offer_sales_to_order_sales')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'customer_id': <?php echo e($price_offer_sales->customer_id); ?>,
                    'price_offer_sales_id': id
                },
                success: function(data) {
                    // console.log(data.redirect);
                    window.location.href = data.redirect;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_qty_price_price_offer_sales_items_ajax(id, value, operation) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById(`loader_${operation}_${id}`).style.display = 'inline';
            $.ajax({
                url: '<?php echo e(route('price_offer_sales.price_offer_sales_items.update_qty_price_price_offer_sales_items_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'operation': operation,
                    'value': value
                },
                success: function(data) {
                    console.log(data);
                    if (data.success == 'true') {
                        toastr.success(data.message);
                        document.getElementById(`loader_${operation}_${id}`).style.display = 'none';
                        // price_offer_sales_items_table_ajax(page);
                        if (value > 0 || $('#price_' + id).val() == '') {
                            $('#price_' + id).css('background-color',
                                'palegoldenrod');
                        } else {
                            $('#price_' + id).css('background-color',
                                '#DC3545');
                        }
                        // get_sum_price_offer_sales_items_ajax();
                    } else if (data.success == 'false') {
                        toastr.error(data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_currency_notes_customer_for_price_offer_sales_items_ajax(value, operation) {
            document.getElementById('currency_id').value = value;
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('price_offer_sales.price_offer_sales_items.update_currency_notes_customer_for_price_offer_sales_items_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'price_offer_sales_id': <?php echo e($price_offer_sales->id); ?>,
                    'operation': operation,
                    'value': value
                },
                success: function(data) {
                    console.log(data);
                    if (data.success == 'true') {
                        toastr.success(data.message);
                    } else if (data.success == 'false') {
                        toastr.error(data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function get_sum_price_offer_sales_items_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('price_offer_sales.price_offer_sales_items.get_sum_price_offer_sales_items_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'price_offer_sales_id': <?php echo e($price_offer_sales->id); ?>,
                },
                success: function(data) {
                    if (data.success == 'true') {
                        document.getElementById('sum_items').innerText = data.sum;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_customer_ajax(customer_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('price_offer_sales.update_customer_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'price_offer_sales_id': <?php echo e($price_offer_sales->id); ?>,
                    'customer_id': customer_id,
                },
                success: function(data) {
                    if (data.success == 'true') {
                        toastr.success(data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        $('#price_offer_found_form').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: $(this).attr('action'),
                method: 'post',
                headers: headers,
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    window.location.href = data.redirect;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        })

        var page = 1;
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            product_list_search(page);
            price_offer_sales_items_table_ajax(page);
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

<?php echo $__env->make('home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/sales/price_offer_sales/price_offer_sales_items/index.blade.php ENDPATH**/ ?>