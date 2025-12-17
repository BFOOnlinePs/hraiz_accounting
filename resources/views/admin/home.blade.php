@php
    $settings = \App\Models\SystemSettingModel::first();
@endphp
@extends('home')

@section('title', 'الرئيسية')
@section('header_title', 'الرئيسية')
@section('header_link', 'الرئيسية')
@section('header_title_link', 'الرئيسية')

@section('content')
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #7209b7;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --danger: #e63946;
            --light: #f8f9fa;
            --dark: #212529;
            --company: #06d6a0;
            --gradient-primary: linear-gradient(135deg, #4361ee, #3a0ca3);
            --gradient-secondary: linear-gradient(135deg, #7209b7, #560bad);
            --gradient-success: linear-gradient(135deg, #4cc9f0, #4895ef);
            --gradient-warning: linear-gradient(135deg, #f72585, #b5179e);
            --gradient-danger: linear-gradient(135deg, #e63946, #d00000);
            --gradient-info: linear-gradient(135deg, #4895ef, #4361ee);
            --gradient-company: linear-gradient(135deg, #06d6a0, #04a777);
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 15px 35px rgba(0, 0, 0, 0.15);
            --radius: 16px;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%) !important;
            color: #333;
            min-height: 100vh;
        }

        .content-wrapper {
            background: transparent !important;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 10px;
        }

        .header p {
            color: #6c757d;
            font-size: 1.1rem;
        }

        /* بطاقة معلومات الشركة */
        .company-info-card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 10px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            border-right: 5px solid var(--company);
        }

        .company-info-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .company-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-company);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 20px;
            flex-shrink: 0;
        }

        .company-icon i {
            font-size: 2.2rem;
            color: white;
        }

        .company-details {
            flex-grow: 1;
        }

        .company-details h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e293b;
        }

        .company-details p {
            display: inline;
            color: #6c757d;
            font-size: 1.1rem;
        }

        .year-badge {
            background: var(--gradient-company);
            color: white;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 1.1rem;
            display: inline-flex;
            align-items: center;
        }

        .year-badge i {
            margin-left: 8px;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
            border: none;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .card-header {
            align-items: center;
            justify-content: space-between;
            position: relative;
            color: white;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            z-index: 1;
        }

        .card-header > * {
            position: relative;
            z-index: 2;
        }

        .card-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            display: inline;
        }

        .card-header .icon {
            font-size: 1.5rem;
            opacity: 0.8;
            float: left;
            display: inline;
        }

        .card-body {
            padding: 20px;
        }

        .btn-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 15px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            text-align: center;
            border: none;
            font-size: 0.9rem;
            position: relative;
            overflow: hidden;
            color: white;
        }

        .btn i {
            margin-left: 8px;
            font-size: 1rem;
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .btn:hover::after {
            transform: translateX(0);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            color: white;
            text-decoration: none;
        }

        /* Card Colors */
        .purchases .card-header {
            background: var(--gradient-primary);
        }
        .purchases .btn {
            background: var(--primary);
        }

        .sales .card-header {
            background: var(--gradient-secondary);
        }
        .sales .btn {
            background: var(--secondary);
        }

        .products .card-header {
            background: var(--gradient-danger);
        }
        .products .btn {
            background: var(--danger);
        }

        .users .card-header {
            background: var(--gradient-info);
        }
        .users .btn {
            background: var(--info);
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .action-card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 25px 20px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .action-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
            text-decoration: none;
            color: inherit;
        }

        .action-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: white;
        }

        .action-card h5 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .action-card p {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Action Card Colors */
        .action-1 i { background: var(--gradient-success); }
        .action-2 i { background: var(--gradient-danger); }
        .action-3 i { background: var(--gradient-warning); }
        .action-4 i { background: var(--gradient-info); }
        .action-5 i { background: #6c757d; }
        .action-6 i { background: var(--dark); }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-size: 0.9rem;
            border-top: 1px solid #e9ecef;
            margin-top: 40px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .company-info-card {
                flex-direction: column;
                text-align: center;
            }

            .company-icon {
                margin-left: 0;
                margin-bottom: 15px;
            }

            .cards-grid {
                grid-template-columns: 1fr;
            }

            .btn-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .quick-actions {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 2rem;
            }

            .company-details h3 {
                font-size: 1.5rem;
            }
        }
    </style>

    @php
        $userRoles = json_decode(auth()->user()->user_role, true);
        // الحصول على اسم الشركة والسنة من قاعدة البيانات أو الجلسة
        $companyName = auth()->user()->company_name ?? 'شركتنا المتميزة';
        $selectedYear = session('selected_year') ?? date('Y');
    @endphp

    @if (in_array('1', $userRoles) || in_array('11', $userRoles))
        <div class="dashboard-container">
{{--            <div class="header">--}}
{{--                <h1>لوحة التحكم الرئيسية</h1>--}}
{{--                <p>مرحباً بك في نظام إدارة الشركة المتكامل</p>--}}
{{--            </div>--}}

            <!-- بطاقة معلومات الشركة -->
            <div class="">

                <div class="company-details">
                    <h3>{{ $settings->company_name }}
                        <p>
                        <div class="year-badge">
                            <i class="fas fa-calendar-alt"></i>
                            السنة المالية: {{ session()->get('login_date') }}
                        </div>
                        </p>

                    </h3>
                    <br>
                </div>
            </div>

            <div class="cards-grid">
                <!-- Purchases Card -->
                <div class="card purchases">
                    <div class="card-header">
                        <h3>المشتريات</h3>
                        <div class="icon">
                            <i class="fas fa-bag-shopping"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="btn-grid">
                            <a class="btn" href="{{ route('accounting.purchase_invoices.index') }}">
                                <i class="fas fa-file-invoice"></i>
                                فواتير مشتريات
                            </a>
                            <a class="btn" href="{{ route('orders.procurement_officer.order_index') }}">
                                <i class="fas fa-clipboard-list"></i>
                                طلبيات شراء
                            </a>
                            <a class="btn" href="{{ route('accounting.returns.index') }}">
                                <i class="fas fa-rotate-left"></i>
                                مردودات مشتريات
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sales Card -->
                <div class="card sales">
                    <div class="card-header">
                        <h3>المبيعات</h3>
                        <div class="icon">
                            <i class="fas fa-cart-shopping"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="btn-grid">
                            <a class="btn" href="{{ route('accounting.sales_invoices.index') }}">
                                <i class="fas fa-receipt"></i>
                                فواتير مبيعات
                            </a>
                            <a class="btn" href="{{ route('price_offer_sales.index') }}">
                                <i class="fas fa-tag"></i>
                                عروض أسعار بيع
                            </a>
                            <a class="btn" href="{{ route('accounting.returns.index') }}">
                                <i class="fas fa-undo-alt"></i>
                                مردود مبيعات
                            </a>
                            <a class="btn" href="{{ route('accounting.orders_sales.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                طلبيات بيع
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Products Card -->
                <div class="card products">
                    <div class="card-header">
                        <h3>الأصناف</h3>
                        <div class="icon">
                            <i class="fas fa-list"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="btn-grid">
                            <a class="btn" href="{{ route('product.index') }}">
                                <i class="fas fa-boxes"></i>
                                قائمة الأصناف
                            </a>
                            <a class="btn" href="{{ route('units.index') }}">
                                <i class="fas fa-balance-scale"></i>
                                الوحدات
                            </a>
                            <a class="btn" href="{{ route('category.index') }}">
                                <i class="fas fa-layer-group"></i>
                                مجموعات الأصناف
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Users Card -->
{{--                <div class="card users">--}}
{{--                    <div class="card-header">--}}
{{--                        <h3>المستخدمين</h3>--}}
{{--                        <div class="icon">--}}
{{--                            <i class="fas fa-users"></i>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="btn-grid">--}}
{{--                            <a class="btn" href="{{ route('users.employees.index') }}">--}}
{{--                                <i class="fas fa-user-tie"></i>--}}
{{--                                موظفين--}}
{{--                            </a>--}}
{{--                            <a class="btn" href="{{ route('users.supplier.index') }}">--}}
{{--                                <i class="fas fa-truck"></i>--}}
{{--                                موردين--}}
{{--                            </a>--}}
{{--                            <a class="btn" href="{{ route('users.clients.index') }}">--}}
{{--                                <i class="fas fa-user-friends"></i>--}}
{{--                                زبائن--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

            <div class="quick-actions">
                <a class="action-card action-1" href="{{ route('accounting.preparation.index') }}">
                    <i class="fas fa-check"></i>
                    <h5>تحضير طلبيات</h5>
                    <p>إدارة وتحضير طلبيات العملاء</p>
                </a>
                <a class="action-card action-2" href="{{ route('production.index') }}">
                    <i class="fas fa-bars"></i>
                    <h5>خطوط الانتاج</h5>
                    <p>مراقبة وإدارة خطوط الإنتاج</p>
                </a>
                @if(!in_array('11', $userRoles))
                    <a class="action-card action-3" href="{{ route('accounting.customer_account_statement_index') }}">
                        <i class="fas fa-table"></i>
                        <h5>كشف حساب</h5>
                        <p>كشف حساب العملاء والموردين</p>
                    </a>
                @endif
                <a class="action-card action-4" href="{{ route('accounting.expenses.index') }}">
                    <i class="fas fa-ils"></i>
                    <h5>مصروفات</h5>
                    <p>إدارة مصروفات الشركة</p>
                </a>
                <a class="action-card action-5" href="{{ route('accounting.bonds.performance_bond.performance_bond_index') }}">
                    <i class="fas fa-file"></i>
                    <h5>سندات صرف</h5>
                    <p>إنشاء وإدارة سندات الصرف</p>
                </a>
                <a class="action-card action-6" href="{{ route('accounting.bonds.payment_bond.index') }}">
                    <i class="fas fa-file-text"></i>
                    <h5>سندات قبض</h5>
                    <p>إنشاء وإدارة سندات القبض</p>
                </a>
            </div>
        </div>
    @endif

    <script>
        // إضافة تأثيرات تفاعلية إضافية
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card, .action-card, .company-info-card');

            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transition = 'all 0.3s ease';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transition = 'all 0.5s ease';
                });
            });
        });
    </script>
@endsection
