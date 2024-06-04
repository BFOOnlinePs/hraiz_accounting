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
    <a href="{{ route('accounting.sales_invoices.new_invoices_index') }}" class="btn btn-dark text-white mb-2">
        فاتورة جديدة
    </a>
    <button type="button" class="btn btn-dark mb-2" data-toggle="modal" data-target="#modal-lg">
        فاتورة من عرض سعر
    </button>
    <div class="card p-3">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">رقم المرجع</label>
                    <input onkeyup="invoice_table_index_ajax()" placeholder="رقم المرجع" id="invoice_reference_number"
                           class="form-control" type="text">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">المورد</label>
                    <select onchange="invoice_table_index_ajax()" class="select2bs4 form-control supplier_select2" name="supplier_id" id="supplier_user_id">
                        <option value="">جميع الموردين</option>
                        @foreach($users as $key)
                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
{{--            <div class="col">--}}
{{--                <div class="form-group">--}}
{{--                    <label for="">متابعة بواسطة</label>--}}
{{--                    <select onchange="getOrderTable()" class="select2bs4 form-control supplier_select2" name="to_user" id="to_user">--}}
{{--                        <option value="">جميع المستخدمين</option>--}}
{{--                        --}}{{--                    @foreach($users as $key)--}}
{{--                        --}}{{--                        <option value="{{ $key->id }}">{{ $key->name }}</option>--}}
{{--                        --}}{{--                    @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="col">
                <div class="form-group">
                    <label for="">حالة الطلبية</label>
                    <select onchange="getOrderTable()" class="form-control" name="order_status" id="order_status">
                        <option value="">جميع الحالات</option>
                        {{--                    @foreach($order_status as $key)--}}
                        {{--                        @if($key->id != 10)--}}
                        {{--                            <option value="{{ $key->id }}">{{ $key->name }}</option>--}}
                        {{--                        @endif--}}
                        {{--                    @endforeach--}}
                    </select>
                </div>
            </div>
{{--            <div class="col">--}}
{{--                <div class="form-group">--}}
{{--                    <label for="">من تاريخ</label>--}}
{{--                    <input onchange="getOrderTable()" name="from" id="from" value="<?php echo date('Y-01-01')?>" type="text" class="form-control date_format">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col">--}}
{{--                <div class="form-group">--}}
{{--                    <label for="">الى تاريخ</label>--}}
{{--                    <input onchange="getOrderTable()" name="to" id="to" value="<?php echo date('Y-m-d')?>" type="text" class="form-control date_format">--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>

    <div class="card">

        {{-- <div class="card-header">
            <h3 class="text-center">قائمة البنوك</h3>
        </div> --}}

        <div class="card-body">
            <div id="invoice_table">

            </div>
{{--            <table class="table table-bordered">--}}
{{--                <thead>--}}
{{--                    <tr>--}}
{{--                        <th>تاريخ الفاتورة</th>--}}
{{--                        <th>تاريخ التسليم</th>--}}
{{--                        <th>العميل</th>--}}
{{--                        <th>الضريبة الاولى</th>--}}
{{--                        <th>الضريبة الثانية</th>--}}
{{--                        <th>الملاحظات</th>--}}
{{--                        <th>العمليات</th>--}}
{{--                    </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                    @if($data->isEmpty())--}}
{{--                        <tr>--}}
{{--                            <td colspan="7" class="text-center">لا توجد بيانات</td>--}}
{{--                        </tr>--}}
{{--                    @else--}}
{{--                    @foreach ($data as $key)--}}
{{--                        <tr>--}}
{{--                            <td>{{ $key->bill_date }}</td>--}}
{{--                            <td>{{ $key->due_date }}</td>--}}
{{--                            <td>{{ App\Models\User::where('id',$key->client_id)->value('name') }}</td>--}}
{{--                            <td>{{ $key->tax_id }}</td>--}}
{{--                            <td>{{ $key->tax_id2 }}</td>--}}
{{--                            <td>{{ $key->note }}</td>--}}
{{--                            <td>--}}
{{--                                <a href="{{ route('accounting.purchase_invoices.edit_invoices',['id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>--}}
{{--                                <a href="{{ route('accounting.purchase_invoices.delete_invoices',['id'=>$key->id]) }}" onclick="return confirm('هل تريد حذف البيانات ؟')" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>--}}
{{--                                <a href="{{ route('accounting.purchase_invoices.invoice_view',['id'=>$key->id]) }}" class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    @foreach ($data as $key)--}}
{{--                @endforeach--}}
{{--                    @endif--}}
{{--                </tbody>--}}
{{--            </table>--}}
        </div>

    </div>
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-xl">
            <form action="{{ route('accounting.purchase_invoices.create_purchase_invoices_from_order') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" id="order_input">
                <input type="hidden" name="supplier_user_id" id="supplier_input">
                <input type="hidden" name="invoice_type" value="sales">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">فاتورة من عرض سعر</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">بحث عن عرض سعر</label>
                                    <input onkeyup="search_order_ajax()" id="input_search" type="text" class="form-control" placeholder="ابحث عن طلبية">
                                    {{-- <select class="form-control select2bs4" name="order_id" id="">
                                        <option value="">اختر الطلبية</option>
                                        @foreach ($order as $key)
                                            <option value="{{ $key->id }}">{{ $key->reference_number }}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">المورد</label>
                                    <select class="form-control select2bs4" name="supplier_id" onchange="search_order_ajax()" id="supplier_id">
                                        <option value="">اختر المورد</option>
                                        @foreach ($users as $key)
                                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="search_order">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                        {{-- <button type="submit" class="btn btn-primary">حفظ</button> --}}
                    </div>

                </div>
            </form>

        </div>
    </div>

@endsection()

@section('script')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    function search_order_ajax(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.sales_invoices.search_order_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'input_search': document.getElementById('input_search').value,
                    'supplier_id': document.getElementById('supplier_id').value,
                    'page': page
                },
                success: function (data) {
                    console.log(data);
                    $('#search_order').html(data.view);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
    function invoice_table_index_ajax(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.sales_invoices.invoice_table_index_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'supplier_user_id': document.getElementById('supplier_user_id').value,
                    'invoice_reference_number': document.getElementById('invoice_reference_number').value,
                    'page': page
                },
                success: function (data) {
                    $('#invoice_table').html(data.view);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }


        window.onload = (event) => {
            search_order_ajax(page);
            invoice_table_index_ajax(page);
        };

        var page = 1;
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            search_order_ajax(page)
            invoice_table_index_ajax(page);
            });
</script>

<script>
    $(function(){
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>
@endsection

