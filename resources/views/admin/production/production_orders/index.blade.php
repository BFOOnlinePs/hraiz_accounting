@extends('home')
@section('title')
    اوامر الانتاج
@endsection
@section('header_title')
    اوامر الانتاج
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    اوامر الانتاج
@endsection
@section('style')
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')

    </button>
    <button class="btn btn-dark" data-toggle="modal" data-target="#create_production_order_modal">اضافة امر انتاج</button>
    <div class="card mt-2">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th>خط الانتاج</th>
                                    <th>الموظف</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الانشاء</th>
                                    <th>تاريخ التسليم</th>
                                    <th>الكمية</th>
                                    <th>الملاحظات</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key)
                                    <tr>
                                        <td>{{ $key->production_lines->production_name }}</td>
                                        <td>{{ $key->user->name }}</td>
                                        <td>
                                            @if($key->status == 'process')
                                                <small class="badge badge-warning">قيد المعالجة</small>
                                            @elseif($key->status == 'new')
                                                <small class="badge badge-info">جديد</small>
                                            @elseif($key->status == 'complete')
                                                <small class="badge badge-success">مكتمل</small>
                                            @endif
                                        </td>
                                        <td>{{ $key->insert_at }}</td>
                                        <td>{{ $key->submission_date }}</td>
                                        <td>{{ $key->qty }}</td>
                                        <td>{{ $key->notes }}</td>
                                        <td>
                                            <a class="btn btn-dark btn-sm" href="{{ route('production.production_inputs.index',['id'=>$key->production_lines->id]) }}"><span class="fa fa-search"></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.production.production_orders.modals.create_production_order_modal')
@endsection()

@section('script')
@endsection

