

<nav class="main-header navbar navbar-expand-md navbar-dark">
    <div class="container">
        
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white text-white" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('home')); ?>" class="nav-link text-white">الرئيسية</a>
                </li>
                <?php if(in_array('1', json_decode(auth()->user()->user_role))): ?>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">الحسابات</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="#" class="dropdown-item">شجرة الحسابات</a></li>
                            <li><a href="<?php echo e(route('users.index')); ?>" class="dropdown-item">المستخدمين</a></li>
                            <li><a href="<?php echo e(route('users.supplier.index')); ?>" class="dropdown-item">الموردين</a></li>
                            <li><a href="<?php echo e(route('users.clients.index')); ?>" class="dropdown-item">الزبائن</a></li>
                            <li><a href="#" class="dropdown-item">النقدية</a></li>
                            <li><a href="#" class="dropdown-item">البنوك</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">مبيعات</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="<?php echo e(route('price_offer_sales.index')); ?>" class="dropdown-item">عروض اسعار
                                    البيع</a></li>
                            <li><a href="<?php echo e(route('accounting.orders_sales.index')); ?>" class="dropdown-item">طلبيات
                                    البيع</a></li>

                            <li><a href="<?php echo e(route('accounting.sales_invoices.index')); ?>" class="dropdown-item">فواتير
                                    مبيعات</a></li>
                            <li><a href="<?php echo e(route('accounting.returns.index')); ?>" class="dropdown-item">مردود مبيعات</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">مشتريات</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="<?php echo e(route('accounting.purchase_invoices.index')); ?>" class="dropdown-item">فواتير
                                    مشتريات</a></li>
                            <li><a href="<?php echo e(route('orders.procurement_officer.order_index')); ?>"
                                    class="dropdown-item">طلبات شراء</a></li>
                            <li><a href="<?php echo e(route('accounting.returns.index')); ?>" class="dropdown-item">مردود
                                    مشتريات</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">الطلبيات</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="<?php echo e(route('accounting.preparation.index')); ?>" class="dropdown-item">التحضير</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">سندات</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="<?php echo e(route('accounting.bonds.performance_bond.performance_bond_index')); ?>"
                                    class="dropdown-item">سندات صرف</a></li>
                            <li><a href="<?php echo e(route('accounting.bonds.payment_bond.index')); ?>"
                                    class="dropdown-item">سندات قبض</a></li>
                            <li><a href="<?php echo e(route('accounting.bonds.registration_bonds.registration_bonds_index')); ?>"
                                    class="dropdown-item">سندات قيد</a></li>
                            <li><a href="<?php echo e(route('accounting.bonds.check.index')); ?>" class="dropdown-item">شكات
                                    واردة ( محفظة )</a></li>

                            <li><a href="<?php echo e(route('accounting.bonds.check.performance_bond_cheques_index')); ?>"
                                    class="dropdown-item">محفظة
                                    الشيكات</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">الأصناف</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="<?php echo e(route('product.index')); ?>" class="dropdown-item">قائمة الأصناف</a></li>
                            <li><a href="<?php echo e(route('category.index')); ?>" class="dropdown-item">مجموعات الأصناف</a>
                            </li>
                            <li><a href="<?php echo e(route('units.index')); ?>" class="dropdown-item">الوحدات</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">الانتاج</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="<?php echo e(route('production.index')); ?>" class="dropdown-item">خطوط الانتاج</a></li>
                            <li><a href="#" class="dropdown-item">مخرجات الانتاج</a></li>
                            <li><a href="<?php echo e(route('production.production_orders.index')); ?>"
                                    class="dropdown-item">اوامر الانتاج</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">الموارد البشرية</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="<?php echo e(route('users.employees.index')); ?>" class="dropdown-item">الموظفين</a>
                            </li>
                            <li><a href="<?php echo e(route('hr.salaries.index')); ?>" class="dropdown-item">الرواتب</a></li>
                            <li><a href="#" class="dropdown-item">الدوام</a></li>
                            <li><a href="#" class="dropdown-item">الحضور و المغادرة</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">المصروفات</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="<?php echo e(route('accounting.expenses.index')); ?>" class="dropdown-item">قائمة
                                    المصروفات</a></li>
                            <li><a href="<?php echo e(route('accounting.expenses_category.index')); ?>"
                                    class="dropdown-item">تصنيف المصروفات</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">التقارير</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="<?php echo e(route('reports.suppliers.suppliers_report')); ?>"
                                    class="dropdown-item">قائمة الموردين</a></li>
                            <li><a href="#" class="dropdown-item">تقرير مورد</a></li>
                            <li><a href="#" class="dropdown-item">تقرير مورد مفصل</a></li>
                            <li><a href="#" class="dropdown-item">تقرير أصناف شركة</a></li>
                            <li><a href="<?php echo e(route('reports.financial_report.financial_report_index')); ?>"
                                    class="dropdown-item">التقارير المالية</a></li>
                            <li class="dropdown-submenu dropdown-hover">
                                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false"
                                    class="dropdown-item dropdown-toggle">كشف حساب</a>
                                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                                    <li>
                                        <a href="<?php echo e(route('accounting.customer_account_statement_index')); ?>"
                                            class="dropdown-item">كشف حساب</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">الاعدادات</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="<?php echo e(route('setting.first_term_balance.index')); ?>" class="dropdown-item">رصيد اول المدة</a></li>
                            <li><a href="<?php echo e(route('currency.index')); ?>" class="dropdown-item">العملات</a></li>
                            <li><a href="<?php echo e(route('bank.index')); ?>" class="dropdown-item">البنوك</a></li>
                            <li><a href="<?php echo e(route('shipping_methods.index')); ?>" class="dropdown-item">طرق الشحن</a>
                            </li>
                            <li><a href="<?php echo e(route('clearance_attachment.index')); ?>" class="dropdown-item">مرفقات
                                    التخليص</a></li>
                            <li><a href="<?php echo e(route('estimation_cost_element.index')); ?>" class="dropdown-item">عناصر
                                    تقدير التكلفة</a></li>
                            <li><a href="<?php echo e(route('order_status.index')); ?>" class="dropdown-item">حالات الطلبيات</a>
                            </li>
                            <li><a href="<?php echo e(route('setting.system_setting.index')); ?>" class="dropdown-item">اعدادات
                                    النظام</a></li>
                            <li><a href="<?php echo e(route('accounting.texes.index')); ?>" class="dropdown-item">الضرائب</a>
                            </li>
                            <li><a href="<?php echo e(route('setting.machine.setting_index')); ?>"
                                    class="dropdown-item">الآلات</a></li>
                            <li><a href="<?php echo e(route('setting.vacations_types.index')); ?>" class="dropdown-item">أنواع
                                    الإجازات</a></li>
                            <li><a href="<?php echo e(route('setting.attendance_device.index')); ?>" class="dropdown-item">ساعات
                                    الدوام</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">المخازن</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="<?php echo e(route('wherehouse.index')); ?>" class="dropdown-item">المخازن</a></li>
                        </ul>
                    </li>
                <?php elseif(in_array('11', json_decode(auth()->user()->user_role))): ?>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">الطلبيات</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="<?php echo e(route('accounting.preparation.index')); ?>"
                                    class="dropdown-item">التحضير</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>

            
        </div>

        
        
    </div>
    <div class="mt-1">
        <span class="text-white"><?php echo e(\Illuminate\Support\Facades\Auth::user()->name); ?></span>
        <a class="text-danger" style="font-size: 12px" href="#"
            onclick="event.preventDefault();document.getElementById('logout-form').submit();">( تسجيل الخروج )</a>

        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo e(csrf_field()); ?>

        </form>

    </div>
</nav>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>