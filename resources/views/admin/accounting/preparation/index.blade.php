@extends('home')
@section('title')
    التحضير
@endsection
@section('header_title')
    التحضير
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    التحضير
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class='table-responsive'>
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>رقم المرجعي للفاتورة</th>
                                    <th>بواسطة</th>
                                    <th>حالة التحضير</th>
                                    <th>تاريخ الاضافة</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">لا يوجد بيانات</td>
                                    </tr>
                                @else
                                    @foreach ($data as $key)
                                        <tr>
                                            <td>{{ $key->order->reference_number }}</td>
                                            <td>{{ $key->fromUser->name }}</td>
                                            <td>
                                                @if ($key->status == 'waiting_prepared')
                                                    بانتظار التجهيز
                                                @elseif ($key->status == 'ready_prepared')
                                                    تم التجهيز
                                                @elseif ($key->status == 'delivered')
                                                    تم التسليم
                                                @endif
                                            </td>
                                            <td>{{ $key->insert_at }}</td>
                                            <td>
                                                <a href="{{ route('accounting.preparation.details', ['preparation_id' => $key->id]) }}"
                                                    class="btn btn-info btn-sm">الدخول الى الطلبية</a>
                                                <a href="{{ route('accounting.preparation.print_qr_code_pdf', ['id' => $key->id]) }}"
                                                    class="btn btn-warning btn-sm"><span class="fa fa-barcode"></span></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
