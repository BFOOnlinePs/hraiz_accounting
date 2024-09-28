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

            <div class="col-lg-6 col-3">
                <div class="small-box bg-info pr-3 pt-4 pb-2">
                    <div class="inner">
                        {{-- <h3>{{ $order_count }}</h3> --}}
                        <h3>مشتريات</h3>
                        <div class="row">
                            <a class="btn btn-sm btn-default bg-white col m-2 p-2" href="#">فواتير مشتريات</a>
                            <a class="btn btn-sm btn-default bg-white col m-2 p-2" href="#">طلبيات شراء</a>
                            <a class="btn btn-sm btn-default bg-white col m-2 p-2" href="#">مردودات مشتريات</a>    
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fa fa-bag-shopping"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-3">
                <div class="small-box bg-success pr-3 pt-4 pb-2">
                    <div class="inner">
                        {{-- <h3>{{ $order_count }}</h3> --}}
                        <h3>مبيعات</h3>
                        <div class="row">
                            <a class="btn btn-sm btn-default bg-white col m-2 p-2" href="#">فواتير مبيعات</a>
                            <a class="btn btn-sm btn-default bg-white col m-2 p-2" href="#">عروض اسعار بيع</a>
                            <a class="btn btn-sm btn-default bg-white col m-2 p-2" href="#">مردود مبيعات</a>    
                            <a class="btn btn-sm btn-default bg-white col m-2 p-2" href="#">طلبيات بيع</a>    
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fa fa-bag-shopping"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-lg-4 col-4">
                        <div class="small-box bg-warning pr-3 pt-4 pb-2">
                            <div class="inner">
                                {{-- <h3>{{ $order_count }}</h3> --}}
                                <h3>موردين</h3>
                                <div class="row">
                                </div>
                            </div>
                            <div class="icon">
                                <i class="fa fa-bag-shopping"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-3">
                        <div class="small-box bg-danger pr-3 pt-4 pb-2">
                            <div class="inner">
                                {{-- <h3>{{ $order_count }}</h3> --}}
                                <h3>زبائن</h3>
                                <div class="row">
                                </div>
                            </div>
                            <div class="icon">
                                <i class="fa fa-bag-shopping"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-3">
                        <div class="small-box bg-warning pr-3 pt-4 pb-2">
                            <div class="inner">
                                {{-- <h3>{{ $order_count }}</h3> --}}
                                <h3>موظفين</h3>
                                <div class="row">
                                </div>
                            </div>
                            <div class="icon">
                                <i class="fa fa-bag-shopping"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-3">
                <div class="small-box bg-warning pr-3 pt-4 pb-2">
                    <div class="inner">
                        {{-- <h3>{{ $order_count }}</h3> --}}
                        <h3>الأصناف</h3>
                        <div class="row">
                            <a class="btn btn-sm btn-default bg-white col m-2 p-2" href="#">فواتير مشتريات</a>
                            <a class="btn btn-sm btn-default bg-white col m-2 p-2" href="#">طلبيات شراء</a>
                            <a class="btn btn-sm btn-default bg-white col m-2 p-2" href="#">مردودات مشتريات</a>    
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fa fa-bag-shopping"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-3">
                <div class="small-box bg-danger pr-3 pt-4 pb-2">
                    <div class="inner">
                        {{-- <h3>{{ $order_count }}</h3> --}}
                        <h3>مشتريات</h3>
                        <div class="row">
                            <a class="btn btn-sm btn-default bg-white col m-2 p-2" href="#">فواتير مشتريات</a>
                            <a class="btn btn-sm btn-default bg-white col m-2 p-2" href="#">طلبيات شراء</a>
                            <a class="btn btn-sm btn-default bg-white col m-2 p-2" href="#">مردودات مشتريات</a>    
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fa fa-bag-shopping"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <span class="">اخر الطلبيات</span>
                        <a href="{{ route('orders.procurement_officer.order_index') }}" class="btn btn-dark btn-sm" style="float: left">عرض الطلبيات</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table id="example1"  class="table table-bordered table-hover text-center dataTable dtr-inline"
                                       aria-describedby="example1_info">
                                    <thead class="bg-dark">
                                    <tr>
                                        {{--                <th>رقم طلبية الشراء</th>--}}
                                        <th>ر.مرجعي</th>
                                        <th width="150">الترسية</th>
                                        <th>بواسطة</th>
                                        <th></th>
                                        @if(!in_array('3',json_decode(auth()->user()->user_role)))
                                            <th>العمليات</th>
                                        @endif
                                        {{--                    <th>العمليات</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $key)
                                        <tr class="">
                                            {{--                    <td>{{ $key->id }}</td>--}}
                                            {{--                    <td>{{ $key->order_id }}</td>--}}
                                            <td>{{ $key->reference_number }}
                                            {{--                            <span onclick="getReferenceNumber({{ $key->order_id }})" class="fa fa-edit text-success" style="float: left" data-toggle="modal" data-target="#modal-reference_number"></span></td>--}}
                                            <td>
                                                @foreach($key->supplier as $child)
                                                    {{ $child['name']->name }},
                                                @endforeach
                                            </td>
                                            <td>{{ $key['user']->name }}</td>
                                            <td>{{ $key->created_at }}</td>
                                            @if(!in_array('3',json_decode(auth()->user()->user_role)))
                                                <td>
                                                    <a href="{{ route('procurement_officer.orders.product.index',['order_id'=>$key->order_id]) }}" class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>
                                                </td>
                                            @endif
                                            {{--                        <td>--}}
                                            {{--                                                        <a href="{{ route('procurement_officer.orders.product.index',['order_id'=>$key->order_id]) }}"--}}
                                            {{--                                                           class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>--}}
                                            {{--                                                    <button type="button" onclick="getReferenceNumber({{ $key->order_id }})" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reference_number">--}}
                                            {{--                                                        تعديل الرقم المرجعي--}}
                                            {{--                                                    </button>--}}
                                            {{--                                                        <a href="{{ route('orders.procurement_officer.delete_order',['id'=>$key->order_id]) }}" onclick="return confirm('هل انت متاكد من عملية الحذف علما انه بعد الحذف سوف يتم نقله لسلة المحذوفات')" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>--}}
                                            {{--                        </td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{--    <div class="col-lg-3 col-6">--}}

                        {{--        <div class="small-box bg-danger">--}}
                        {{--            <div class="inner">--}}
                        {{--                <h3>65</h3>--}}
                        {{--                <p>Unique Visitors</p>--}}
                        {{--            </div>--}}
                        {{--            <div class="icon">--}}
                        {{--                <i class="ion ion-pie-graph"></i>--}}
                        {{--            </div>--}}
                        {{--            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
                        {{--        </div>--}}
                        {{--    </div>--}}

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <span class="text-center">التقويم</span>
                        <a href="{{ route('calendar.index') }}" class="btn btn-dark btn-sm" style="float: left">عرض التقويم</a>
                    </div>

                    <div class="card-body">
                        <div id="calendar-ajax">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
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
