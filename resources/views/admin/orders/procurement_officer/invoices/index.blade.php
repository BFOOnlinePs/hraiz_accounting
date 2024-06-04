@extends('home')
@section('title')
    الفواتير
@endsection
@section('header_title')
    طلب شراء <span>
        @if ($order->reference_number != 0)
            #{{ $order->reference_number }}
        @endif
    </span>
@endsection
@section('header_link')
    الفواتير
@endsection
@section('header_title_link')
    الفواتير
@endsection
@section('style')

@endsection
@section('content')

    {{--    @include('admin.orders.progreesbar') --}}
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    @include('admin.orders.order_menu')
    <div class="card">
        <div class="card-header">
            <h4 class="text-center">الفواتير</h4>
        </div>
        <div class="card-body">
            <button class="btn btn-dark mb-2" data-toggle="modal" data-target="#create_invoice">انشاء فاتورة</button>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>تاريخ الفاتورة</th>
                                <th>تاريخ التسليم</th>
                                <th>العميل</th>
                                <th>الضريبة الاولى</th>
                                <th>الضريبة الثانية</th>
                                <th>الملاحظات</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($data->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">لا توجد فواتير</td>
                                </tr>
                            @else
                                @foreach ($data as $key)
                                    <tr>
                                        <td>{{ $key->bill_date }}</td>
                                        <td>{{ $key->due_date }}</td>
                                        <td>{{ $key->user->name }}</td>
                                        <td>{{ $key->tax_id }}</td>
                                        <td>{{ $key->tax_id2 }}</td>
                                        <td>{{ $key->note }}</td>
                                        <td>
                                            <a href="{{ route('accounting.purchase_invoices.invoice_view',['id'=>$key->id]) }}" class="btn btn-success btn-sm">عرض الفاتورة</a>
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
    <div class="modal fade" id="create_invoice">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{route('procurement_officer.orders.invoices.create')}}" method="post">
                    @csrf
                    <input type="hidden" name="order_id" value="{{$order->id}}">
                    <div class="modal-header">
                    <h4 class="modal-title">انشاء فاتورة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اختر مورد تمت الترسية عليه</label>
                                <select required class="form-control" name="supplier_id" id="">
                                    <option value="">اختر مورد</option>
                                    @foreach($users_award as $key)
                                        <option value="{{$key->user->id}}">{{$key->user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-dark">حفظ</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection()

@section('script')

@endsection
