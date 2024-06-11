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
                    alert('error');
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

