@extends('home')
@section('title')
    فواتير المبيعات
@endsection
@section('header_title')
    فواتير المبيعات
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    فواتير المبيعات
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="row">
        <div class="col-md-12">
            <h4>ارشيف الطلبات</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('accounting.sales_invoices.index') }}" class="btn btn-info">فواتير البيع</a>
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
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-sm table-bordered text-center">
                                <thead class="bg-dark">
                                    <tr>
                                        {{--        <td>#</td> --}}
                                        <td>الرقم المرجعي</td>
                                        <th>تاريخ الفاتورة</th>
                                        <th>تاريخ التسليم</th>
                                        <th>العميل</th>
                                        <th>المجموع</th>
                                        <th>الملاحظات</th>
                                        <th>الحالة</th>
                                        <th style="width: 130px">العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->isEmpty())
                                        <tr>
                                            <td colspan="9" class="text-center">لا توجد بيانات</td>
                                        </tr>
                                    @else
                                        @foreach ($data as $key)
                                            <tr>
                                                {{--                <td>{{ ($data ->currentpage()-1) * $data ->perpage() + $loop->index + 1 }}</td> --}}
                                                <td class="text-left">{{ $key->invoice_reference_number }}</td>
                                                <td class="text-left">{{ $key->bill_date }}</td>
                                                <td>{{ $key->due_date }}</td>
                                                <td>{{ App\Models\User::where('id', $key->client_id)->value('name') }}</td>
                                                <td>{{ $key->totalAmount }}</td>
                                                <td>{{ $key->note }}</td>
                                                <td class="text-center">
                                                    @if ($key->status == 'stage')
                                                        <span class="badge bg-success w-100">مرحل</span>
                                                    @else
                                                        <span class="badge bg-warning w-100">غير مرحل</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('accounting.sales_invoices.invoice_view', ['id' => $key->id]) }}"
                                                        class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>
                                                    <a href="{{ route('accounting.sales_invoices.edit_invoices', ['id' => $key->id]) }}"
                                                        class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                                    <a @if ($key->status == 'stage') disabled @endif
                                                        href="{{ route('accounting.sales_invoices.restore_invoices', ['id' => $key->id]) }}"
                                                        onclick="return confirm('هل تريد استعادة الفاتورة ؟')"
                                                        class="btn btn-info btn-sm"><span
                                                            class="fa fa-arrow-left"></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($data as $key)
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()

@section('script')
@endsection
