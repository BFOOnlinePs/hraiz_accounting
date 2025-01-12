{{-- <nav class="main-header navbar navbar-expand-md navbar-dark navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-white" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link text-white">الرئيسية</a>
        </li>
        <li class="pt-2 text-success">
            <span>شركة جيلانكو للتجارة والصناعة</span>
        </li>
    </ul>


    </ul>
    <div class="mt-1">
        {{ \Illuminate\Support\Facades\Auth::user()->name }}
        <a class="text-danger" style="font-size: 12px" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">( تسجيل الخروج )</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>

    </div>
</nav> --}}

<nav class="main-header navbar navbar-expand-md navbar-dark">
    <div class="container">
        {{-- <a href="../../index3.html" class="navbar-brand">
            <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a> --}}
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
                    <a href="{{ route('home') }}" class="nav-link text-white">الرئيسية</a>
                </li>
                @if (in_array('1', json_decode(auth()->user()->user_role)))
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">الحسابات</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="#" class="dropdown-item">شجرة الحسابات</a></li>
                            <li><a href="{{ route('users.index') }}" class="dropdown-item">المستخدمين</a></li>
                            <li><a href="{{ route('users.supplier.index') }}" class="dropdown-item">الموردين</a></li>
                            <li><a href="{{ route('users.clients.index') }}" class="dropdown-item">الزبائن</a></li>
                            <li><a href="#" class="dropdown-item">النقدية</a></li>
                            <li><a href="#" class="dropdown-item">البنوك</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">مبيعات</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="{{ route('price_offer_sales.index') }}" class="dropdown-item">عروض اسعار
                                    البيع</a></li>
                            <li><a href="{{ route('accounting.orders_sales.index') }}" class="dropdown-item">طلبيات
                                    البيع</a></li>

                            <li><a href="{{ route('accounting.sales_invoices.index') }}" class="dropdown-item">فواتير
                                    مبيعات</a></li>
                            <li><a href="{{ route('accounting.returns.index') }}" class="dropdown-item">مردود مبيعات</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">مشتريات</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="{{ route('accounting.purchase_invoices.index') }}" class="dropdown-item">فواتير
                                    مشتريات</a></li>
                            <li><a href="{{ route('orders.procurement_officer.order_index') }}"
                                    class="dropdown-item">طلبات شراء</a></li>
                            <li><a href="{{ route('accounting.returns.index') }}" class="dropdown-item">مردود
                                    مشتريات</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">الطلبيات</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="{{ route('accounting.preparation.index') }}" class="dropdown-item">التحضير</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">سندات</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="{{ route('accounting.bonds.performance_bond.performance_bond_index') }}"
                                    class="dropdown-item">سندات صرف</a></li>
                            <li><a href="{{ route('accounting.bonds.payment_bond.index') }}"
                                    class="dropdown-item">سندات قبض</a></li>
                            <li><a href="{{ route('accounting.bonds.registration_bonds.registration_bonds_index') }}"
                                    class="dropdown-item">سندات قيد</a></li>
                            <li><a href="{{ route('accounting.bonds.check.index') }}" class="dropdown-item">شكات
                                    واردة ( محفظة )</a></li>

                            <li><a href="{{ route('accounting.bonds.check.performance_bond_cheques_index') }}"
                                    class="dropdown-item">محفظة
                                    الشيكات</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">الأصناف</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="{{ route('product.index') }}" class="dropdown-item">قائمة الأصناف</a></li>
                            <li><a href="{{ route('category.index') }}" class="dropdown-item">مجموعات الأصناف</a>
                            </li>
                            <li><a href="{{ route('units.index') }}" class="dropdown-item">الوحدات</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">الانتاج</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="{{ route('production.index') }}" class="dropdown-item">خطوط الانتاج</a></li>
                            <li><a href="#" class="dropdown-item">مخرجات الانتاج</a></li>
                            <li><a href="{{ route('production.production_orders.index') }}"
                                    class="dropdown-item">اوامر الانتاج</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">الموارد البشرية</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="{{ route('users.employees.index') }}" class="dropdown-item">الموظفين</a>
                            </li>
                            <li><a href="{{ route('hr.salaries.index') }}" class="dropdown-item">الرواتب</a></li>
                            <li><a href="#" class="dropdown-item">الدوام</a></li>
                            <li><a href="#" class="dropdown-item">الحضور و المغادرة</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">المصروفات</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="{{ route('accounting.expenses.index') }}" class="dropdown-item">قائمة
                                    المصروفات</a></li>
                            <li><a href="{{ route('accounting.expenses_category.index') }}"
                                    class="dropdown-item">تصنيف المصروفات</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">التقارير</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="{{ route('reports.suppliers.suppliers_report') }}"
                                    class="dropdown-item">قائمة الموردين</a></li>
                            <li><a href="#" class="dropdown-item">تقرير مورد</a></li>
                            <li><a href="#" class="dropdown-item">تقرير مورد مفصل</a></li>
                            <li><a href="#" class="dropdown-item">تقرير أصناف شركة</a></li>
                            <li><a href="{{ route('reports.financial_report.financial_report_index') }}"
                                    class="dropdown-item">التقارير المالية</a></li>
                            <li class="dropdown-submenu dropdown-hover">
                                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false"
                                    class="dropdown-item dropdown-toggle">كشف حساب</a>
                                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                                    <li>
                                        <a href="{{ route('accounting.customer_account_statement_index') }}"
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
                            <li><a href="{{ route('setting.first_term_balance.index') }}" class="dropdown-item">رصيد اول المدة</a></li>
                            <li><a href="{{ route('currency.index') }}" class="dropdown-item">العملات</a></li>
                            <li><a href="{{ route('bank.index') }}" class="dropdown-item">البنوك</a></li>
                            <li><a href="{{ route('shipping_methods.index') }}" class="dropdown-item">طرق الشحن</a>
                            </li>
                            <li><a href="{{ route('clearance_attachment.index') }}" class="dropdown-item">مرفقات
                                    التخليص</a></li>
                            <li><a href="{{ route('estimation_cost_element.index') }}" class="dropdown-item">عناصر
                                    تقدير التكلفة</a></li>
                            <li><a href="{{ route('order_status.index') }}" class="dropdown-item">حالات الطلبيات</a>
                            </li>
                            <li><a href="{{ route('setting.system_setting.index') }}" class="dropdown-item">اعدادات
                                    النظام</a></li>
                            <li><a href="{{ route('accounting.texes.index') }}" class="dropdown-item">الضرائب</a>
                            </li>
                            <li><a href="{{ route('setting.machine.setting_index') }}"
                                    class="dropdown-item">الآلات</a></li>
                            <li><a href="{{ route('setting.vacations_types.index') }}" class="dropdown-item">أنواع
                                    الإجازات</a></li>
                            <li><a href="{{ route('setting.attendance_device.index') }}" class="dropdown-item">ساعات
                                    الدوام</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">المخازن</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="{{ route('wherehouse.index') }}" class="dropdown-item">المخازن</a></li>
                        </ul>
                    </li>
                @elseif (in_array('11', json_decode(auth()->user()->user_role)))
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" class="nav-link text-white dropdown-toggle">الطلبيات</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="{{ route('accounting.preparation.index') }}"
                                    class="dropdown-item">التحضير</a></li>
                        </ul>
                    </li>
                @endif
            </ul>

            {{-- <form class="form-inline ml-0 ml-md-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form> --}}
        </div>

        {{-- <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

            <li class="nav-item dropdown">
                <a class="nav-link text-white" data-toggle="dropdown" href="#">
                    <i class="fas fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">

                        <div class="media">
                            <img src="../../dist/img/user1-128x128.jpg" alt="User Avatar"
                                class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>

                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">

                        <div class="media">
                            <img src="../../dist/img/user8-128x128.jpg" alt="User Avatar"
                                class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>

                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">

                        <div class="media">
                            <img src="../../dist/img/user3-128x128.jpg" alt="User Avatar"
                                class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>

                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>

            {{-- <li class="nav-item dropdown">
                <a class="nav-link text-white" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li> --}}
        {{-- </ul> --}}
    </div>
    <div class="mt-1">
        <span class="text-white">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
        <a class="text-danger" style="font-size: 12px" href="#"
            onclick="event.preventDefault();document.getElementById('logout-form').submit();">( تسجيل الخروج )</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>

    </div>
</nav>
