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
            <button class="btn btn-dark" @if ($data->order_status == 'invoice_has_been_posted') disabled @endif
                onclick="open_add_product_modal()">اضافة اصناف</button>
            {{-- <form class="d-inline" action="{{ route('accounting.sales_invoices.create_purchase_invoices_from_order') }}"
                method="post">
                @csrf
                <input type="hidden" value="{{ $data->id }}" name="order_id" id="order_input">
                <input type="hidden" value="{{ $data->user_id }}" name="supplier_user_id" id="supplier_input">
                <input type="hidden" name="invoice_type" value="sales">
                <button type="sumbit" class="btn btn-secondary" @if ($data->order_status == 'invoice_has_been_posted') disabled @endif>انشاء
                    فاتورة من
                    طلبية البيع</button>
            </form> --}}
            <button type="sumbit" onclick="order_sales_select_item_ajax()" class="btn btn-secondary"
                @if ($data->order_status == 'invoice_has_been_posted') disabled @endif>انشاء
                فاتورة من
                طلبية البيع</button>

            {{--            <a href="{{  route('accounting.orders_sales.order_sales_pdf',['price_offer_id'=>$data->id]) }}" class="btn btn-warning float-right" @if ($data->order_status == 'invoice_has_been_posted') onclick="return false;" style="pointer-events: none; opacity: 0.6;" @endif><span class="fa fa-print"></span></a> --}}
            {{--            <a href="{{  route('accounting.orders_sales.order_sales_pdf',['price_offer_id'=>$data->id]) }}" class="btn btn-warning float-right"><span class="fa fa-print"></span></a> --}}
            <button class="btn btn-warning float-right" data-toggle="modal" data-target="#order_sales_print_modal"><span
                    class="fa fa-print"></span></button>
            <button class="btn btn-dark mr-1 float-right" data-toggle="modal" data-target="#add_preparation_modal">ارسال الى
                التحضير</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if ($data->order_status == 'invoice_has_been_posted')
                        <div class="alert alert-success text-center">
                            تم ترحيل طلبية البيع بنجاح
                        </div>
                    @endif
                    {{--                    <a href="" class="btn btn-warning"><span class="fa fa-print"></span></a> --}}
                    @if (empty($data->price_offer_sales_id))
                        <div class="row text-center">
                            <div class="col-md-12 alert alert-info">
                                تم انشاء طلبية البيع استناداً لعرض سعر رقم <a
                                    href="{{ route('price_offer_sales.price_offer_sales_items.price_offer_sales_items_index', ['id' => $data->price_offer_sales_id]) }}"
                                    target="_blank" class="btn btn-dark btn-sm">{{ $data->price_offer_sales_id }}</a> وتم
                                اضافة التاريخ بشكل تلقائي
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label for="">الرقم المرجعي لطلبية البيع</label>
                                        <input @if ($data->order_status == 'invoice_has_been_posted') disabled @endif type="text"
                                            onchange="update_orders_sales({{ $data->id }},'reference_number',this.value)"
                                            class="form-control" value="{{ $data->reference_number }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">العميل</label>
                                        <select disabled name="client_id" id="" class="form-control select2bs4">
                                            <option value="">اختر عميل ...</option>
                                            @foreach ($clients as $key)
                                                <option @if ($key->id == $data->user_id) selected @endif
                                                    value="{{ $key->id }}">{{ $key->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">تاريخ اصدار طلبية البيع</label>
                                        <input type="date" @if ($data->order_status == 'invoice_has_been_posted') disabled @endif
                                            class="form-control"
                                            onchange="update_orders_sales({{ $data->id }},'inserted_at',this.value)"
                                            value="{{ $data->inserted_at }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-2">
                            <form action="{{ route('accounting.orders_sales.update_order_sales_status') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <button @if ($data->order_status == 'invoice_has_been_posted') disabled @endif class="btn btn-info form-control" style="height: 100%">
                                    <span class="text-success">@if ($data->order_status == 'invoice_has_been_posted') <span class="fa fa-check-circle"></span> @endif</span>
                                    <p>ترحيل</p>
                                </button>
                            </form>
                        </div> --}}
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
    @include('admin.accounting.orders_sales.modals.order_sales_print_modal')
    @include('admin.accounting.orders_sales.modals.add_preparation_modal')
    @include('admin.accounting.orders_sales.modals.add_orders_sales')
    @include('admin.accounting.orders_sales.modals.create_order_from_order_sales')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
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
                    'page': page,
                    'search': $('#product_search').val()
                },
                success: function(data) {
                    $('#product_list_table').html(data.view)
                },
                error: function(jqXHR, textStatus, errorThrown) {
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
                    'order_id': {{ $data->id }}
                },
                success: function(data) {
                    $('#list_product_details').html(data.view)
                },
                error: function(jqXHR, textStatus, errorThrown) {
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
                    'order_id': {{ $data->id }},
                    'product_id': product_id,
                },
                success: function(data) {
                    orders_sales_items_list_ajax();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_orders_sales_items(id, key, value) {
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
                    'id': id,
                    'key': key,
                    'value': value,
                },
                success: function(data) {

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('حدث خطا اثناء المعالجة');
                }
            });
        }

        function update_orders_sales(id, key, value) {
            if (!id || !key || value === undefined || value === null || value === '') {
                alert('يجب إدخال مدخل صحيح');
                return;
            }
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.orders_sales.update_orders_sales') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'key': key,
                    'value': value,
                },
                success: function(data) {

                },
                error: function(jqXHR, textStatus, errorThrown) {
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
                    'id': id,
                },
                success: function(data) {
                    orders_sales_items_list_ajax();
                    order_sales_select_item_ajax
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function add_price_offer_sales_to_order_sales() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.orders_sales.add_price_offer_sales_to_order_sales') }}',
                method: 'post',
                headers: headers,
                data: {
                    price_offer_sales_id : {{ $data->id }},
                    customer_id : {{ $data->user_id }},
                },
                success: function (response) {
                    window.location.href
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

        function post_the_invoice() {
            window.location.href = '<?php echo route('accounting.orders_sales.orders_sales_details', ['order_id' => $data->id]); ?>'
        }

        function order_sales_select_item_ajax() {
            $('#create_order_from_order_sales').modal('show');

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.orders_sales.order_sales_select_item_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': {{ $data->id }}
                },
                success: function(data) {
                    $('#order_sales_list').html(data.view)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        $('input[name="radio_button"]').change(function() {
            if ($('#print_qr').is(':checked')) {
                order_sales_select_item_ajax();
            } else {
                $('#list_order_sales_product_for_qr').html('');
            }
        });

        function order_sales_select_item_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.orders_sales.list_order_sales_product_for_qr') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': {{ $data->id }}
                },
                success: function(data) {
                    $('#list_order_sales_product_for_qr').html(data.view)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
    </script>

    <script>
        $(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection
