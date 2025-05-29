
<?php $__env->startSection('title'); ?>
    فاتورة جديدة
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title'); ?>
    فاتورة جديدة
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_link'); ?>
    فاتورة المبيعات
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title_link'); ?>
    فاتورة جديدة
<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.messge_alert.success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.messge_alert.fail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="card card-success card-outline">
        <div class="card-body">
            <form action="<?php echo e(route('accounting.sales_invoices.create_new_invoices')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row text-center">
                    <div class="col-md-12">
                        <h1>فاتورة مبيعات جديدة</h1>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">العميل</label>
                                    <select required class="form-control select2bs4" name="client_id" id="">
                                        <option value="">اختر عميل</option>
                                        <?php $__currentLoopData = $client; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key->id); ?>"><?php echo e($key->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="">الرقم المرجعي للفاتورة</label>
                                    <input required value="INV_00<?php echo e($get_invoice_order_number); ?>" name="invoice_reference_number" placeholder="ادخل الرقم المرجعي" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <?php
                                    $month = date('m');
                                    $day = date('d');
                                    $year = date('Y');
                                    $today = $year . '-' . $month . '-' . $day;
                                    ?>
                                    <label for="">تاريخ الفاتورة</label>
                                    <input required type="date" name="bill_date" class="form-control text-center"
                                           value="<?php echo e($today); ?>">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="">الضريبة</label>
                                    <select name="tax_id" id="tax_id" class="form-control select2bs4">
                                        <option value="">اختر قيمة الضريبة ...</option>
                                        <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key->id); ?>"><?php echo e($key->tax_name); ?> (<?php echo e($key->tax_ratio); ?>%)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">العملة</label>
                                    <select required name="currency_id" id="currency_id" class="form-control select2bs4">
                                        <option value="">اختر العملة ...</option>
                                        <?php $__currentLoopData = $currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key->id); ?>"><?php echo e($key->currency_name); ?> <?php echo e($key->currency_symbol); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">ملاحظات</label>
                                    <textarea style="background-color: #ffbc0773" class="form-control" placeholder="يرجى ادخال الملاحظات" name="note" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div style="display: none" id="recurring_form" class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">التكرار خلال</label>
                                            <input type="text" name="repeat_every" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">خلال</label>
                                            <select class="form-control" name="repeat_type" id="">
                                                <option value="days">يوم</option>
                                                <option value="weeks">اسبوع</option>
                                                <option value="months">شهر</option>
                                                <option value="years">سنة</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">الدورة</label>
                                            <input type="text" name="no_of_cycles" class="form-control" placeholder="الدورة">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-dark">انشاء فاتورة مبيعات</button>
            </form>
        </div>
    </div>

    <?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/plugins/select2/js/select2.full.min.js')); ?>"></script>

    <script>
        // 
        // 
        // 

        // 
        // 

        // 
        // 

        // 
        // 
        // 
        // 
        // 
        // 
        // 
        // 


        function if_checked() {
            var checkbox = document.getElementById("checkbox");
            var recurring_form = document.getElementById("recurring_form");

            if (checkbox.checked == true) {
                recurring_form.style.display = "block";
            } else {
                recurring_form.style.display = "none";
            }
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

<?php echo $__env->make('home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/sales_invoices/new_invoice/index.blade.php ENDPATH**/ ?>