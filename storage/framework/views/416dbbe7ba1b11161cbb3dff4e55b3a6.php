
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
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/toastr/toastr.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">

    <style>
        .search_table th {
            text-align: center
        }

        .search_table td {
            text-align: center
        }

        .search_table td input {
            width: 90px;
            text-align: center
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.messge_alert.success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.messge_alert.fail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="small-box bg-light text-white border border-success">
                <div class="inner">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="text-bold text-dark m-1">فاتورة مبيعات # <?php echo e($data->id); ?> - <span
                                    class="text-danger"><?php echo e($data->invoice_reference_number); ?></span></h4>
                        </div>
                        <div class="col-md-8">
                            <div class="row ml-2">
                                
                                <button class="btn btn-sm btn-warning col-md-2 col-12 m-1 p-2" data-toggle="modal"
                                    data-target="#add_print_language_modal"><span class="fa fa-print"></span> &nbsp;&nbsp;
                                    <span>طباعة</span></button>
                                <?php if($purchase_invoice->status != 'stage'): ?>
                                    <button <?php if($purchase_invoice->status == 'stage'): ?> disabled <?php endif; ?> onclick="post_the_invoice()"
                                        class="btn btn-sm btn-info col-md-2 col-12 m-1 p-2"><span
                                            class="fa fa-check"></span>&nbsp;&nbsp;<span>ترحيل الفاتورة</span></button>
                                <?php endif; ?>
                                <?php if($purchase_invoice->status == 'stage'): ?>
                                    <div class="btn btn-sm btn-success col-md-4 col-12 m-1 p-2">
                                        <span class="fa fa-check"></span>
                                        &nbsp;
                                        &nbsp;
                                        <span>تم ترحيل هذه الفاتورة</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php if($purchase_invoice->order_id != null): ?>
                        <div class="row text-center">
                            <div class="col-md-12 alert alert-info">
                                تم انشاء هذه الفاتورة استناداً لطلبية رقم <a
                                    href="<?php echo e(route('procurement_officer.orders.product.index', ['order_id' => $purchase_invoice->order_id])); ?>"
                                    class="btn btn-dark btn-sm"><?php echo e($purchase_invoice->order->reference_number ?? ''); ?></a> وتم
                                اضافة التاريخ بشكل تلقائي
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md">
                                    <div class="from-group">
                                        <label for="">الرقم المرجعي للفاتورة</label>
                                        <input type="text" <?php if($purchase_invoice->status == 'stage'): ?> readonly <?php endif; ?>
                                            onchange="update_invoice_reference_number_ajax(this.value)"
                                            class="form-control arabicNumbers"
                                            value="<?php echo e($purchase_invoice->invoice_reference_number); ?>">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">من</label>
                                        <select disabled name="client_id" id="" class="form-control select2bs4">
                                            <option value="">اختر عميل ...</option>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php if($key->id == $purchase_invoice->client_id): ?> selected <?php endif; ?>
                                                    value="<?php echo e($key->id); ?>"><?php echo e($key->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md">
                                    <div class="form-group">
                                        <?php
                                        $month = date('m');
                                        $day = date('d');
                                        $year = date('Y');
                                        $today = $year . '-' . $month . '-' . $day;
                                        ?>
                                        <label for="">تاريخ الفاتورة</label>
                                        <input <?php if($purchase_invoice->status == 'stage'): ?> readonly <?php endif; ?>
                                            onchange="update_purchase_invoices_from_ajax('bill_date',this.value)"
                                            type="date" name="bill_date" class="form-control text-center"
                                            value="<?php echo e($purchase_invoice->bill_date); ?>">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <?php
                                        $month = date('m');
                                        $day = date('d');
                                        $year = date('Y');
                                        $today = $year . '-' . $month . '-' . $day;
                                        ?>
                                        <label for="">تاريخ الاستحقاق</label>
                                        <input <?php if($purchase_invoice->status == 'stage'): ?> readonly <?php endif; ?>
                                            onchange="update_purchase_invoices_from_ajax('due_date',this.value)"
                                            type="date" name="due_date" class="form-control text-center"
                                            value="<?php echo e($purchase_invoice->due_date); ?>">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">العملة</label>
                                        <input type="text" class="form-control" readonly value="<?php echo e($data->currency->currency_name ?? ''); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div style="display: none" id="recurring_form" class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">التكرار خلال</label>
                                                <input <?php if($purchase_invoice->status == 'stage'): ?> readonly <?php endif; ?>
                                                    onchange="update_purchase_invoices_from_ajax('repeat_every',this.value)"
                                                    value="<?php echo e($purchase_invoice->repeat_every); ?>" type="text"
                                                    name="repeat_every" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">خلال</label>
                                                <select <?php if($purchase_invoice->status == 'stage'): ?> disabled <?php endif; ?>
                                                    onchange="update_purchase_invoices_from_ajax('repeat_type',this.value)"
                                                    class="form-control" name="repeat_type" id="">
                                                    <option <?php if($purchase_invoice->repeat_type == 'days'): ?> selected <?php endif; ?>
                                                        value="days">يوم</option>
                                                    <option <?php if($purchase_invoice->repeat_type == 'weeks'): ?> selected <?php endif; ?>
                                                        value="weeks">اسبوع</option>
                                                    <option <?php if($purchase_invoice->repeat_type == 'months'): ?> selected <?php endif; ?>
                                                        value="months">شهر</option>
                                                    <option <?php if($purchase_invoice->repeat_type == 'years'): ?> selected <?php endif; ?>
                                                        value="years">سنة</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">الدورة</label>
                                                <input <?php if($purchase_invoice->status == 'stage'): ?> readonly <?php endif; ?>
                                                    value="<?php echo e($purchase_invoice->no_of_cycles); ?>" type="text"
                                                    onchange="update_purchase_invoices_from_ajax('no_of_cycles',this.value)"
                                                    name="no_of_cycles" class="form-control" placeholder="الدورة">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if($purchase_invoice->status != 'stage'): ?>
                        <button onclick="show_form_product()" type="button" id="add_product" class="btn btn-info mb-2">
                            اضافة صنف
                        </button>
                    <?php endif; ?>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div id="invoices_table">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">ملاحظات</label>
                            <textarea style="background-color: #ffbc0773" <?php if($purchase_invoice->status == 'stage'): ?> readonly <?php endif; ?> class="form-control"
                                name="note" onchange="update_purchase_invoices_from_ajax('note',this.value)" id="" cols="30"
                                rows="3"><?php echo e($purchase_invoice->note); ?></textarea>
                        </div>
                    </div>
                    <div style="position: fixed; left: 20px; bottom: 20px;height:500px;" id="toastsContainerBottomLeft"
                        class="toasts-bottom-left fixed">
                        <div class="toast border border-success fade" style="background-color:rgba(255,255,255);"
                            id="form_product" role="alert" aria-live="assertive" aria-atomic="true"
                            style="width: 100%; height: 100%;">
                            <div class="toast-header">
                                <strong class="mr-auto">قائمة الأصناف</strong>
                                <button type="button" class="ml-2 mb-1 close" onclick="close_form_product()">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="toast-body">
                                <input type="text" id="search_product" onkeyup="search_product_ajax(this.value)"
                                    class="form-control border border-success" placeholder="بحث عن عنصر">
                                <div style="width: 300px;display:block" class="mt-2">
                                    <div id="search_product_table">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="discount-modal">
        <div class="modal-dialog modal-lg">
            <form action="<?php echo e(route('accounting.texes.create')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">الضريبة</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">قيمة الضريبة</label>
                                    <select class="form-control" name="" id="tax_ratio">
                                        <option value="">لا يوجد ضريبة</option>
                                        <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php if($key->id == $purchase_invoice->tax_id): ?> selected <?php endif; ?>
                                                value="<?php echo e($key->id); ?>"><?php echo e($key->tax_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">نوع الضريبة</label>
                                    <select class="form-control" name="" id="tax_type">
                                        <option value="before">الاسعار شامل الضريبة</option>
                                        <option value="after">الضريبة تضاف على المجموع</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                        <button onclick="update_tax_type()" type="button" class="btn btn-primary">حفظ</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <?php echo $__env->make('admin.accounting.sales_invoices.invoices.modals.print_language', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/plugins/toastr/toastr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/select2/js/select2.full.min.js')); ?>"></script>

    <script>
        function validateForm() {
            var inputs = document.querySelectorAll('[id^="qty_input_"], [id^="rate_input_"]');
            var isEmpty = false;

            inputs.forEach(function(input) {
                if (input.value.trim() === '') {
                    isEmpty = true;
                    return;
                }
            });

            if (isEmpty) {
                alert('يرجى ملئ جميع حقول الاسعار والكميات في الاصناف');
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }

        function show_form_product() {
            document.getElementById('form_product').classList.add('show');
            document.getElementById('form_product').style.display = 'block';
        }

        function close_form_product() {
            document.getElementById('form_product').classList.remove('show');
            document.getElementById('form_product').style.display = 'none';
        }

        function search_product_ajax(search_product, page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.sales_invoices.search_product_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'search_product': search_product,
                    'invoice_id': <?php echo e($purchase_invoice->id); ?>,
                    'page': page
                },
                success: function(data) {
                    console.log(data);
                    $('#search_product_table').html(data.view);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function invoices_table() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('invoices_table').innerHTML =
                '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '<?php echo e(route('accounting.sales_invoices.invoice_table')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'invoice_id': <?php echo e($data->id); ?>,
                },
                success: function(data) {
                    // console.log(data);
                    $('#invoices_table').html(data.view);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function create_product_ajax(index) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.sales_invoices.create_product_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'item_id': document.getElementById('item_id_' + index).value,
                    'invoice_id': <?php echo e($data->id); ?>

                },
                success: function(data) {
                    console.log(data.view);
                    invoices_table();
                    search_product_ajax(document.getElementById('search_product').value, page);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function delete_item(id) {
            var message_result = confirm('هل تريد حذف العنصر ؟');
            if (message_result) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '<?php echo e(route('accounting.sales_invoices.delete_item')); ?>',
                    method: 'post',
                    headers: headers,
                    data: {
                        'id': id,
                    },
                    success: function(data) {
                        invoices_table();
                        toastr.success('تم حذف العنصر بنجاح')
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            }
        }

        function edit_inputs_from_invoice(id, value, operation) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };

            $.ajax({
                url: '<?php echo e(route('accounting.sales_invoices.edit_inputs_from_invoice')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'operation': operation,
                    'value': value
                },
                success: function(data) {
                    updateTotal(id);
                    updateSubTotal();
                    toastr.success('تم التعديل بنجاح');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_invoice_reference_number_ajax(value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };

            $.ajax({
                url: '<?php echo e(route('accounting.sales_invoices.update_invoice_reference_number_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'id': <?php echo e($purchase_invoice->id); ?>,
                    'invoice_reference_number': value
                },
                success: function(data) {
                    if (data.status == 'true') {
                        toastr.success(data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_purchase_invoices_from_ajax(operation, value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.sales_invoices.update_purchase_invoices_from_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'id': <?php echo e($purchase_invoice->id); ?>,
                    'operation': operation,
                    'value': value
                },
                success: function(data) {
                    console.log(data);
                    toastr.success(data.message)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_taxes_ajax(tax_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.sales_invoices.update_purchase_invoices_from_ajax')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'tax_id': tax_id,
                },
                success: function(data) {
                    console.log(data);
                    toastr.success(data.message)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_tax_id_ratio() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '<?php echo e(route('accounting.sales_invoices.update_tax_id_ratio')); ?>',
                method: 'post',
                headers: headers,
                data: {
                    'id': <?php echo e($purchase_invoice->id); ?>,
                    'tax_id': document.getElementById('tax_ratio').value,
                },
                success: function(data) {
                    console.log(data);
                    toastr.success(data.message);
                    invoices_table();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        $(document).ready(function() {
            document.getElementById('form_product').style.display = 'none';
            search_product_ajax(document.getElementById('search_product').value, page);
            invoices_table();
        });



        var page = 1;
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            search_product_ajax(document.getElementById('search_product').value, page);
        });

        $(function() {
            $(document).on("keypress", function() {
                $("#search_product").focus();
            });
        });

        // ترحيل الفاتورة
        function post_invoice() {
            validate = validateForm();
            if (validate === true) {
                window.location.href =
                    '<?php echo e(route('accounting.sales_invoices.invoice_posting', ['id' => $purchase_invoice->id])); ?>';
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#tax_id1').on('change', function() {
                var selectedValue = $(this).val();

                // Clear the options in tax_id2
                $('#tax_id2').empty();

                // Add default option to tax_id2
                $('#tax_id2').append('<option value="">اختر قيمة الضريبة ...</option>');

                // Add formatted options to tax_id2 based on the selected value in tax_id
                <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    if ('<?php echo e($key->id); ?>' !== selectedValue) {
                        $('#tax_id2').append(
                            '<option value="<?php echo e($key->id); ?>"><?php echo e($key->tax_name); ?> (<?php echo e($key->tax_ratio); ?>%)</option>'
                        );
                    }
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            });
        });

        function alerttt() {

        }

        function if_checked() {
            var checkbox = document.getElementById("checkbox");
            var recurring_form = document.getElementById("recurring_form");

            if (checkbox.checked == true) {
                recurring_form.style.display = "block";
            } else {
                recurring_form.style.display = "none";
            }
        }

        function post_the_invoice() {
            // if ($('#wherehouse_select').val()) {
            window.location.href =
                '<?php echo e(route('accounting.sales_invoices.invoice_posting', ['id' => $purchase_invoice->id])); ?>'
            // } else {
            //     alert('يجب ان تحدد المخزن')
            // }
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

<?php echo $__env->make('home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/sales_invoices/invoices/view.blade.php ENDPATH**/ ?>