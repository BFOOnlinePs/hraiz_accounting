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
                            <h4 class="text-bold m-1">ارشيف طلبيات البيع</h4>
                        </div>
                        <div class="col-md-9">
                            <div class="row ml-2">
                                <a href="{{ route('accounting.orders_sales.index')}}" class="btn btn-sm btn-light col-md-3 col-12 m-1 p-2"
                                    ><span
                                        class="fa fa-plus"></span>&nbsp;&nbsp;<span>قائمة طلبيات البيع</span></a>
                            </div>
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

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12" id="archive_order_sales_table" class="table-responsive">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                url: '{{ route('accounting.orders_sales.archive.archive_order_sales_list') }}',
                method: 'post',
                headers: headers,
                data: {
                    reference_name: $('#reference_number').val(),
                    user_id: $('#client_id').val(),
                    page: page
                },
                success: function(data) {
                    $('#archive_order_sales_table').html(data.view)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

    </script>
@endsection
