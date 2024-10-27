@extends('home')
@section('title')
    طلبيات البيع
@endsection
@section('header_title')
    طلبيات البيع
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    طلبيات البيع
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="small-box bg-dark text-white border border-dark">
                <div class="inner">
                    <div class="row">
                        <div class="col-md-3">
                            <h4 class="text-bold m-1">طلبيات البيع</h4>
                        </div>
                        <div class="col-md-9">
                            <div class="row ml-2">
                                <button class="btn btn-sm btn-light col-md-3 col-12 m-1 p-2" data-toggle="modal"
                                    data-target="#add_orders_sales_modal"><span
                                        class="fa fa-plus"></span>&nbsp;&nbsp;<span>اضافة طلبية</span></button>
                                <button class="btn btn-light btn-sm col-md-3 col-12 m-1 p-2"
                                    onclick="open_add_sales_price_offer_modal()"><span
                                        class="fa fa-file-text"></span>&nbsp;&nbsp;<span>اضافة طلبية من عرض سعر
                                        بيع</span></button>
                            </div>
                        </div>
                    </div>
                    {{-- <h3>{{ $order_count }}</h3> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-12">
            <button class="btn btn-dark" data-toggle="modal" data-target="#add_orders_sales_modal">اضافة طلبية</button>
            <button class="btn btn-dark" onclick="open_add_sales_price_offer_modal()">اضافة طلبية من عرض سعر بيع</button>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">الرقم المرجعي</label>
                            <input class="form-control" onkeyup="list_orders_sales_ajax()" id="reference_number"
                                type="text">
                        </div>
                        <div class="col-md-6">
                            <label for="">الزبون</label>
                            <select onchange="list_orders_sales_ajax()" class="form-control select2bs4" id="client_id"
                                name="">
                                <option value="">اختر زبون ...</option>
                                @foreach ($clients as $key)
                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="orders_sales_table">

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.accounting.orders_sales.modals.add_product_modal')
    @include('admin.accounting.orders_sales.modals.add_orders_sales')
    @include('admin.accounting.orders_sales.modals.add_sales_price_offer_modal')
    @include('admin.accounting.orders_sales.modals.sales_price_offer_items')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            list_orders_sales_ajax(page);
            list_price_offer_sales_ajax();
        });
        var page = 1;

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            list_orders_sales_ajax(page);
        });

        function list_orders_sales_ajax(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.orders_sales.list_orders_sales_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    reference_name: $('#reference_number').val(),
                    user_id: $('#client_id').val(),
                    page: page
                },
                success: function(data) {
                    $('#orders_sales_table').html(data.view)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function open_add_sales_price_offer_modal() {
            $('#add_sales_price_offer_modal').modal('show');
        }

        function list_price_offer_sales_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.orders_sales.price_offer_sales_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'client_id': $('#select_client').val()
                },
                success: function(data) {
                    $('#sales_price_offer_table').html(data.view)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

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

        function add_price_offer_sales_to_order_sales(data) {
            $('#price_offer_sales_id_input').val(data.id);
            $('#supplier_user_id_input').val(data.customer_id);
            $('#sales_price_offer_items').modal('show');
            list_price_offer_items(data.id, data.customer_id);
            // var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // var headers = {
            //     "X-CSRF-Token": csrfToken
            // };
            // $.ajax({
            //     url: '{{ route('accounting.orders_sales.add_price_offer_sales_to_order_sales') }}',
            //     method: 'post',
            //     headers: headers,
            //     data: {
            //         price_offer_sales_id: data.id,
            //         customer_id: data.user.id,
            //     },
            //     success: function(response) {
            //         window.location.href = response.redirect;
            //     },
            //     error: function(jqXHR, textStatus, errorThrown) {
            //         alert('error');
            //     }
            // });
        }

        function open_add_product_modal() {
            $('#add_product_modal').modal('show');
            product_list_ajax();
        }

        function list_price_offer_items(order_id, supplier_id) {
            $('#create_order_from_order_sales').modal('show');

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.orders_sales.list_price_offer_items') }}',
                method: 'post',
                headers: headers,
                data: {
                    order_id: order_id,
                    supplier_id: supplier_id,
                },
                success: function(data) {

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

        function update_order_sales_status_ajax(order_id, order_status) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.orders_sales.update_order_sales_status_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    order_id: order_id,
                    order_status: order_status
                },
                success: function(data) {
                    $('#select_order_status_' + order_id).removeClass(
                        'bg-info bg-success bg-warning bg-danger bg-primary');
                    if (order_status == 'new') {
                        $('#select_order_status_' + order_id).addClass('bg-info');
                    } else if (order_status == 'invoice_send_preparation') {
                        $('#select_order_status_' + order_id).addClass('bg-primary');
                    } else if (order_status == 'pending') {
                        $('#select_order_status_' + order_id).addClass('bg-warning');
                    } else if (order_status == 'ready') {
                        $('#select_order_status_' + order_id).addClass('bg-success');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
    </script>
@endsection
