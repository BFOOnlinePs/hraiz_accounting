
<?php $__env->startSection('title'); ?>
    الرئيسية
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title'); ?>
    الرئيسية
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_link'); ?>
    الرئيسية
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_title_link'); ?>
    الرئيسية
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php
        $userRoles = json_decode(auth()->user()->user_role, true); // Decode JSON string into PHP array
    ?>
    <?php if(in_array('1', $userRoles)): ?>
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="small-box bg-dots-darker border border-warning pr-3 pt-4 pb-2">
                    <div class="inner">
                        
                        <h3>مشتريات</h3>
                        <div class="row mt-4">
                            <a class="btn btn-sm btn-warning col-lg col-12 m-1 p-2"
                                href="<?php echo e(route('accounting.purchase_invoices.index')); ?>">فواتير مشتريات</a>
                            <a class="btn btn-sm btn-warning col-lg col-12 m-1 p-2"
                                href="<?php echo e(route('orders.procurement_officer.order_index')); ?>">طلبيات شراء</a>
                            <a class="btn btn-sm btn-warning col-lg col-12 m-1 p-2"
                                href="<?php echo e(route('accounting.returns.index')); ?>">مردودات مشتريات</a>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fa fa-bag-shopping"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="small-box bg-dots-darker border border-success pr-3 pt-4 pb-2">
                    <div class="inner">
                        
                        <h3>مبيعات</h3>
                        <div class="row mt-4">
                            <a class="btn btn-sm btn-success col-lg col-12 m-1 p-2"
                                href="<?php echo e(route('accounting.sales_invoices.index')); ?>">فواتير مبيعات</a>
                            <a class="btn btn-sm btn-success col-lg col-12 m-1 p-2"
                                href="<?php echo e(route('price_offer_sales.index')); ?>">عروض اسعار بيع</a>
                            <a class="btn btn-sm btn-success col-lg col-12 m-1 p-2"
                                href="<?php echo e(route('accounting.returns.index')); ?>">مردود مبيعات</a>
                            <a class="btn btn-sm btn-success col-lg col-12 m-1 p-2"
                                href="<?php echo e(route('accounting.orders_sales.index')); ?>">طلبيات بيع</a>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fa fa-cart-shopping"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="small-box bg-dots-darker border border-danger pr-3 pt-4 pb-2">
                    <div class="inner">
                        
                        <h3>الأصناف</h3>
                        <div class="row mt-4">
                            <a class="btn btn-sm btn-danger col-lg col-12 m-1 p-2" href="<?php echo e(route('product.index')); ?>">قائمة
                                الأصناف</a>
                            <a class="btn btn-sm btn-danger col-lg col-12 m-1 p-2"
                                href="<?php echo e(route('units.index')); ?>">الوحدات</a>
                            <a class="btn btn-sm btn-danger col-lg col-12 m-1 p-2"
                                href="<?php echo e(route('category.index')); ?>">مجموعات الأصناف</a>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="small-box bg-dots-darker border border-info pr-3 pt-4 pb-2">
                    <div class="inner">
                        
                        <h3>المستخدمين</h3>
                        <div class="row mt-4">
                            <a class="btn btn-sm btn-info col-lg col-12 m-1 p-2"
                                href="<?php echo e(route('users.employees.index')); ?>">موظفين</a>
                            <a class="btn btn-sm btn-info col-lg col-12 m-1 p-2"
                                href="<?php echo e(route('users.supplier.index')); ?>">موردين</a>
                            <a class="btn btn-sm btn-info col-lg col-12 m-1 p-2"
                                href="<?php echo e(route('users.clients.index')); ?>">زبائن</a>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <a class="col-md-2 col-12" href="<?php echo e(route('accounting.preparation.index')); ?>">
                <div class="bg-success text-center col-md-12 m-1 p-3">
                    <h2 class="fa fa-check">
                        </h1>
                        <h5>تحضير طلبيات</h4>
                </div>
            </a>
            <a class="col-md-2 col-12" href="<?php echo e(route('production.index')); ?>">
                <div class="btn btn-danger text-center col-md-12 m-1 p-3">
                    <h2 class="fa fa-bars">
                        </h1>
                        <h5>خطوط الانتاج</h4>
                </div>
            </a>
            <a class="col-md-2 col-12" href="<?php echo e(route('accounting.customer_account_statement_index')); ?>">
                <div class="btn btn-warning text-white text-center col-md-12 m-1 p-3">
                    <h2 class="fa fa-table">
                        </h1>
                        <h5 class="text-dark">كشف حساب</h4>
                </div>
            </a>
            <a class="col-md-2 col-12" href="<?php echo e(route('accounting.sales_invoices.index')); ?>">
                <div class="btn btn-info text-center col-md-12 m-1 p-3">
                    <h2 class="fa fa-ils">
                        </h1>
                        <h5>مصروفات</h4>
                </div>
            </a>
            <a class="col-md-2 col-12" href="<?php echo e(route('accounting.preparation.index')); ?>">
                <div class="btn btn-secondary text-center col-md-12 m-1 p-3">
                    <h2 class="fa fa-file">
                        </h1>
                        <h5>سندات صرف</h4>
                </div>
            </a>
            <a class="col-md-2 col-12" href="<?php echo e(route('accounting.preparation.index')); ?>">
                <div class="btn btn-dark text-center col-md-12 m-1 p-3">
                    <h2 class="fa fa-file-text">
                        </h1>
                        <h5>سندات قبض</h4>
                </div>
            </a>
        </div>
    <?php elseif(in_array('11', \GuzzleHttp\json_decode(auth()->user()->user_role))): ?>
        <div class="card">
            <div class="card-body">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>خط الانتاج</th>
                            <th>الموظف</th>
                            <th>الحالة</th>
                            <th>تاريخ الانشاء</th>
                            <th>تاريخ التسليم</th>
                            <th>الكمية</th>
                            <th>الملاحظات</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($production_orders->isEmpty()): ?>
                            <tr>
                                <td colspan="7" class="text-center">لا توجد بيانات</td>
                            </tr>
                        <?php else: ?>
                            <?php $__currentLoopData = $production_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key->production_lines->production_name); ?></td>
                                    <td><?php echo e($key->user->name); ?></td>
                                    <td><?php echo e($key->status); ?></td>
                                    <td><?php echo e($key->insert_at); ?></td>
                                    <td><?php echo e($key->submission_date); ?></td>
                                    <td><?php echo e($key->qty); ?></td>
                                    <td><?php echo e($key->notes); ?></td>
                                    <td>
                                        <a class="btn btn-dark btn-sm"
                                            href="<?php echo e(route('production.production_inputs.index', ['id' => $key->production_lines->id])); ?>"><span
                                                class="fa fa-search"></span></a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <div class="modal fade" id="create_payment_bond_for_client_modal">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <input type="hidden" name="invoice_modal_type" value="client">
            <div class="modal-content">
                <div class="modal-body p-5">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="d-inline">تحديث ارصدة اول المدة</h5>
                            <div class="d-inline">
                                <a href="<?php echo e(route('setting.first_term_balance.index')); ?>" class="btn btn-sm btn-success float-right">تحديث ارصدة اول المدة</a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p>في ما يلي قائمة بالارصدة التي بحاجة الى ترصيد من السنة الماضية</p>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>الزبون</th>
                                        <th>دائن</th>
                                        <th>مدين</th>
                                        <th>الرصيد</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(empty($item['first_term_balance'])): ?>
                                    <tr>
                                        <td><?php echo e($item['client']['name']); ?></td>
                                        <td><?php echo e($item['debit']); ?></td>
                                        <td><?php echo e($item['credit']); ?></td>
                                        <td>
                                            <?php if($item['balance'] < 0): ?>
                                                <span class="text-danger"><?php echo e($item['balance']); ?></span>
                                            <?php else: ?>
                                                <span class=""><?php echo e($item['balance']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src='<?php echo e(asset('assets/calendar/js/cdn.jsdelivr.net_npm_fullcalendar@6.1.8_index.global.min.js')); ?>'></script>
    <script>
        $(document).ready(function() {
            $('#create_payment_bond_for_client_modal').modal('show');
        });

        function CalendarJs() {
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headers: {
                        center: 'title'
                    },
                    editable: false,
                    events: '<?php echo e(route('calendar.getEvents')); ?>',
                    eventResize(event, delta) {
                        alert(event);
                    },
                    eventRender: function(event, element, view) {
                        if (event.allDay === 'true') {
                            event.allDay = true;
                        } else {
                            event.allDay = false;
                        }
                    },
                    selectable: true,
                    selectHelper: true,
                    select: function(start, end, allDay, startStr) {
                        var modal = $('#modal-lg-calendar').modal();
                        var submit_button = document.getElementById('submit_button');
                        submit_button.addEventListener("click", function() {
                            $.ajax({
                                url: "<?php echo e(route('procurement_officer.orders.calender.create')); ?>",
                                type: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                data: {
                                    start: start['startStr'],
                                },
                                success: function(data) {
                                    console.log(data);
                                    // calendar.refetchEvents();
                                    calendar.addEvent({
                                        id: data.id,
                                        start: data['start'],
                                    });

                                    calendar.unselect();
                                    $('#modal-lg-calendar').modal('hide');

                                }
                            });
                        });

                    },
                    // events: [
                    //     {
                    //         title: 'event1',
                    //         start: '2023-08-14',
                    //     },
                    //     {
                    //         title: 'event2',
                    //         start: '2023-08-12',
                    //         end: '2023-08-18',
                    //     },
                    //     {
                    //         title: 'event3',
                    //         start: '2023-08-14T12:30:00',
                    //         allDay: false // will make the time show
                    //     }
                    // ],


                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    

                    direction: 'rtl',
                    dateClick: function(info) {
                        // The info parameter contains information about the clicked day
                        var clickedDate = info;
                        // console.log(info);
                        // $('#modal-lg-calendar').modal();
                        // Perform your custom action here
                    }
                });
                calendar.render();
            });

        }

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

        window.onload = CalendarJs();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/home.blade.php ENDPATH**/ ?>