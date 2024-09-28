@extends('home')
@section('title')
    الرئيسية
@endsection
@section('header_title')
    الرئيسية
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    الرئيسية
@endsection
@section('content')
    @php
        $userRoles = json_decode(auth()->user()->user_role, true); // Decode JSON string into PHP array
    @endphp
    @if(in_array("1", $userRoles))
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="small-box bg-dots-darker border border-warning pr-3 pt-4 pb-2">
                    <div class="inner">
                        {{-- <h3>{{ $order_count }}</h3> --}}
                        <h3>مشتريات</h3>
                        <div class="row mt-4">
                            <a class="btn btn-sm btn-warning col-lg col-12 m-1 p-2" href="{{ route('accounting.purchase_invoices.index') }}">فواتير مشتريات</a>
                            <a class="btn btn-sm btn-warning col-lg col-12 m-1 p-2" href="{{ route('orders.procurement_officer.order_index') }}">طلبيات شراء</a>
                            <a class="btn btn-sm btn-warning col-lg col-12 m-1 p-2" href="{{ route('accounting.returns.index') }}">مردودات مشتريات</a>    
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
                        {{-- <h3>{{ $order_count }}</h3> --}}
                        <h3>مبيعات</h3>
                        <div class="row mt-4">
                            <a class="btn btn-sm btn-success col-lg col-12 m-1 p-2" href="{{ route('accounting.sales_invoices.index') }}">فواتير مبيعات</a>
                            <a class="btn btn-sm btn-success col-lg col-12 m-1 p-2" href="{{ route('price_offer_sales.index') }}">عروض اسعار بيع</a>
                            <a class="btn btn-sm btn-success col-lg col-12 m-1 p-2" href="{{ route('accounting.returns.index') }}">مردود مبيعات</a>    
                            <a class="btn btn-sm btn-success col-lg col-12 m-1 p-2" href="{{ route('accounting.orders_sales.index') }}">طلبيات بيع</a>    
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
                        {{-- <h3>{{ $order_count }}</h3> --}}
                        <h3>الأصناف</h3>
                        <div class="row mt-4">
                            <a class="btn btn-sm btn-danger col-lg col-12 m-1 p-2" href="{{ route('product.index') }}">قائمة الأصناف</a>
                            <a class="btn btn-sm btn-danger col-lg col-12 m-1 p-2" href="{{ route('units.index') }}">الوحدات</a>
                            <a class="btn btn-sm btn-danger col-lg col-12 m-1 p-2" href="{{ route('category.index') }}">مجموعات الأصناف</a>    
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
                        {{-- <h3>{{ $order_count }}</h3> --}}
                        <h3>المستخدمين</h3>
                        <div class="row mt-4">
                            <a class="btn btn-sm btn-info col-lg col-12 m-1 p-2" href="{{ route('users.employees.index') }}">موظفين</a>
                            <a class="btn btn-sm btn-info col-lg col-12 m-1 p-2" href="{{ route('users.supplier.index') }}">موردين</a>
                            <a class="btn btn-sm btn-info col-lg col-12 m-1 p-2" href="{{ route('users.clients.index') }}">زبائن</a>    
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <a class="col-md-2 col-12" href="{{ route('accounting.preparation.index') }}">
                    <div class="bg-success text-center col-md-12 m-1 p-3">
                        <h2 class="fa fa-check"></h1>
                        <h5>تحضير طلبيات</h4>
                    </div>
            </a>
            <a class="col-md-2 col-12" href="{{ route('production.index') }}">
                    <div class="btn btn-danger text-center col-md-12 m-1 p-3">
                        <h2 class="fa fa-bars"></h1>
                        <h5>خطوط الانتاج</h4>
                    </div>
        </a>
        <a class="col-md-2 col-12" href="{{ route('accounting.customer_account_statement_index') }}">
                <div class="btn btn-warning text-white text-center col-md-12 m-1 p-3">
                    <h2 class="fa fa-table"></h1>
                    <h5 class="text-dark">كشف حساب</h4>
                </div>
    </a>
    <a class="col-md-2 col-12" href="{{ route('accounting.sales_invoices.index') }}">
            <div class="btn btn-info text-center col-md-12 m-1 p-3">
                <h2 class="fa fa-ils"></h1>
                <h5>مصروفات</h4>
            </div>
</a>
<a class="col-md-2 col-12" href="{{ route('accounting.preparation.index') }}">
        <div class="btn btn-secondary text-center col-md-12 m-1 p-3">
            <h2 class="fa fa-file"></h1>
            <h5>سندات صرف</h4>
        </div>
</a>
<a class="col-md-2 col-12" href="{{ route('accounting.preparation.index') }}">
        <div class="btn btn-dark text-center col-md-12 m-1 p-3">
            <h2 class="fa fa-file-text"></h1>
            <h5>سندات قبض</h4>
        </div>
</a>
        </div>
    @elseif(in_array("11", \GuzzleHttp\json_decode(auth()->user()->user_role)))
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
                    @if($production_orders->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center">لا توجد بيانات</td>
                        </tr>
                    @else
                        @foreach($production_orders as $key)
                            <tr>
                                <td>{{ $key->production_lines->production_name }}</td>
                                <td>{{ $key->user->name }}</td>
                                <td>{{ $key->status }}</td>
                                <td>{{ $key->insert_at }}</td>
                                <td>{{ $key->submission_date }}</td>
                                <td>{{ $key->qty }}</td>
                                <td>{{ $key->notes }}</td>
                                <td>
                                    <a class="btn btn-dark btn-sm" href="{{ route('production.production_inputs.index',['id'=>$key->production_lines->id]) }}"><span class="fa fa-search"></span></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection()
@section('script')
    <script
        src='{{ asset('assets/calendar/js/cdn.jsdelivr.net_npm_fullcalendar@6.1.8_index.global.min.js') }}'></script>
    <script>

        function CalendarJs() {
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headers: {
                        center: 'title'
                    },
                    editable: false,
                    events: '{{ route('calendar.getEvents') }}',
                    eventResize(event, delta) {
                        alert(event);
                    },
                    eventRender: function (event, element, view) {
                        if (event.allDay === 'true') {
                            event.allDay = true;
                        } else {
                            event.allDay = false;
                        }
                    },
                    selectable: true,
                    selectHelper: true,
                    select: function (start, end, allDay, startStr) {
                        var modal = $('#modal-lg-calendar').modal();
                        var submit_button = document.getElementById('submit_button');
                        submit_button.addEventListener("click", function () {
                            $.ajax({
                                url: "{{ route('procurement_officer.orders.calender.create') }}",
                                type: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    start: start['startStr'],
                                },
                                success: function (data) {
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


                    {{--select:function (start, end, allDay,startStr){--}}
                        {{--    var modal = $('#modal-lg-calendar').modal();--}}
                        {{--    var submit_button = document.getElementById('submit_button');--}}
                        {{--    submit_button.addEventListener("click", function() {--}}
                        {{--        $.ajax({--}}
                        {{--            url:"{{ route('procurement_officer.orders.calender.create') }}",--}}
                        {{--            type:"POST",--}}
                        {{--            headers:{--}}
                        {{--                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')--}}
                        {{--            },--}}
                        {{--            data:{--}}
                        {{--                notification_time: start['startStr'],--}}
                        {{--            },--}}
                        {{--            success:function(data)--}}
                        {{--            {--}}
                        {{--                console.log(data);--}}
                        {{--                calendar.refetchEvents();--}}
                        {{--                $('#modal-lg-calendar').modal('hide');--}}
                        {{--            }--}}
                        {{--        })--}}
                        {{--    });--}}
                        {{--},--}}

                    direction: 'rtl',
                    dateClick: function (info) {
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

        {{--function getCalendar() {--}}
            {{--    var csrfToken = $('meta[name="csrf-token"]').attr('content');--}}
            {{--    var headers = {--}}
            {{--        "X-CSRF-Token": csrfToken--}}
            {{--    };--}}
            {{--    $.ajax({--}}
            {{--        url: '{{ url('users/procurement_officer/orders/calender/calendar_ajax') }}',--}}
            {{--        method: 'get',--}}
            {{--        headers: headers,--}}
            {{--        success: function (data) {--}}
            {{--            $('#calendar-ajax').html(data);--}}
            {{--            // calendarJS();--}}
            {{--        },--}}
            {{--        error: function (jqXHR, textStatus, errorThrown) {--}}
            {{--            alert('error');--}}
            {{--        }--}}
            {{--    });--}}
            {{--}--}}

            window.onload = CalendarJs();
    </script>

@endsection
