@extends('home')
@section('title')
    تفاصيل طلبية البيع
@endsection
@section('header_title')
    تفاصيل طلبية البيع
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    تفاصيل طلبية البيع
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
            <button class="btn btn-dark" onclick="open_add_product_modal()">اضافة اصناف</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if($data->status == 'stage')
                        <div class="alert alert-success text-center">
                            تم ترحيل هذه الفاتورة بنجاح
                        </div>
                    @endif
{{--                    <a href="" class="btn btn-warning"><span class="fa fa-print"></span></a>--}}
                    @if($data->price_offer_sales_id != null)
                        <div class="row text-center">
                            <div class="col-md-12 alert alert-info">
                                تم انشاء هذه الفاتورة استناداً لعرض سعر رقم <a href="{{ route('price_offer_sales.price_offer_sales_items.price_offer_sales_items_index',['id' => $data->price_offer_sales_id]) }}" target="_blank" class="btn btn-dark btn-sm">{{ $data->price_offer_sales_id }}</a> وتم اضافة التاريخ بشكل تلقائي
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label for="">الرقم المرجعي للفاتورة</label>
                                        <input @if($data->status == 'stage') disabled @endif type="text" onchange="update_invoice_reference_number_ajax(this.value)" readonly class="form-control" value="{{ $data->reference_number }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">العميل</label>
                                        <select disabled name="client_id" id="" class="form-control select2bs4">
                                            <option value="">اختر عميل ...</option>
                                            @foreach ($clients as $key)
                                                <option @if($key->id == $data->user_id) selected @endif value="{{ $key->id }}">{{ $key->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">تاريخ اصدار الفاتورة</label>
                                        <input type="text" readonly class="form-control" value="{{ $data->inserted_at }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            {{--                    <button @if($data->status == 'stage') disabled @endif onclick="window.location.href='{{ route('accounting.sales_invoices.invoice_posting',['id'=>$data->id]) }}'" class="btn btn-info form-control" style="height: 100%">ترحيل</button>--}}
                            <button @if($data->status == 'stage') disabled @endif onclick="post_invoice()" class="btn btn-info form-control" style="height: 100%">
                                <span class="text-success">@if($data->status == 'stage') <span class="fa fa-check-circle"></span> @endif</span>
                                <p>ترحيل</p>
                            </button>
                        </div>
                        {{--                <div class="col-md-4 p-3 card bg-warning">--}}
                        {{--                        <div class="row">--}}
                        {{--                            <div class="col-md-12">--}}
                        {{--                                <div class="from-group">--}}
                        {{--                                    <label for="">الرقم المرجعي للفاتورة</label>--}}
                        {{--                                    <input type="text" onchange="update_invoice_reference_number_ajax(this.value)" class="form-control" value="{{ $data->invoice_reference_number }}">--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                            <div class="col-md-12">--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                    <label for="">العميل</label>--}}
                        {{--                                    <select disabled name="client_id" id="" class="form-control select2bs4">--}}
                        {{--                                        <option value="">اختر عميل ...</option>--}}
                        {{--                                        @foreach ($users as $key)--}}
                        {{--                                            <option @if($key->id == $data->client_id) selected @endif value="{{ $key->id }}">{{ $key->name }}</option>--}}
                        {{--                                        @endforeach--}}
                        {{--                                    </select>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                            <div class="col-md-12">--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                    <label for="">حالة الفاتورة</label>--}}
                        {{--                                    <select name="" class="form-control" id="">--}}
                        {{--                                        <option value="">اختر حالة الفاتورة ...</option>--}}
                        {{--                                        <option value="">فاتورة جديدة غير مرحلة</option>--}}
                        {{--                                        <option value="">فاتورة مرحلة</option>--}}
                        {{--                                    </select>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                        {{--                </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="list_product_details">

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.accounting.orders_sales.modals.add_product_modal')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            orders_sales_items_list_ajax(1);
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            product_list_ajax(page);
        });

        function product_list_ajax(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.orders_sales.product_list_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'page' : page,
                    'search' : $('#product_search').val()
                },
                success: function (data) {
                    $('#product_list_table').html(data.view)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function orders_sales_items_list_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.orders_sales.orders_sales_items_list_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id' : {{ $data->id }}
                },
                success: function (data) {
                    $('#list_product_details').html(data.view)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function create_orders_sales_items(product_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.orders_sales.create_orders_sales_items') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id' : {{ $data->id }},
                    'product_id' : product_id,
                },
                success: function (data) {
                    orders_sales_items_list_ajax();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_orders_sales_items(id,key,value) {
            if (!id || !key || value === undefined || value === null || value === '') {
                alert('يجب إدخال مدخل صحيح');
                return;
            }
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.orders_sales.update_orders_sales_items') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id' : id,
                    'key' : key,
                    'value' : value,
                },
                success: function (data) {

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('حدث خطا اثناء المعالجة');
                }
            });
        }

        function delete_orders_sales_items(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.orders_sales.delete_orders_sales_items') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id' : id,
                },
                success: function (data) {
                    orders_sales_items_list_ajax();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function open_add_product_modal() {
            $('#add_product_modal').modal('show');
            product_list_ajax();
        }
    </script>

    <script>
        $(function(){
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection

