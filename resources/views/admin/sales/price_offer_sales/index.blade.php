@extends('home')
@section('title')
    عروض اسعار البيع
@endsection
@section('header_title')
    عروض اسعار البيع
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    عروض اسعار البيع
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
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
                            <h4 class="text-bold m-1">عروض اسعار البيع</h4>
                        </div>
                        <div class="col-md-9">
                            <div class="row ml-2 w-100">
                                <button type="button" class="btn btn-light btn-sm col-md-3 col-12 m-1 p-2"
                                    data-toggle="modal" data-target="#create_price_offer_sales_modal">
                                    <span class="fa fa-plus"></span>
                                    &nbsp;
                                    &nbsp;
                                    <span>اضافة عرض سعر بيع</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- <h3>{{ $order_count }}</h3> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">الزبون</label>
                        <select onchange="price_offer_sales_table_ajax()" class="form-control select2bs4" name=""
                            id="customer_id">
                            <option value="">الكل</option>
                            @foreach ($clients as $key)
                                @if (in_array(4, json_decode($key->user_role)))
                                    مورد |
                                    <span>
                                        {{ $key->name }}
                                    </span>
                                @elseif (in_array(10, json_decode($key->user_role)))
                                    زبون |
                                    <span>
                                        {{ $key->name }}
                                    </span>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">تمت الاضافة بواسطة</label>
                        <select onchange="price_offer_sales_table_ajax()" class="form-control select2bs4" name=""
                            id="insert_by">
                            <option value="">الكل</option>
                            @foreach ($added_by as $key)
                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">من</label>
                                <input onchange="price_offer_sales_table_ajax()" type="date" id="from"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">الى</label>
                                <input onchange="price_offer_sales_table_ajax()" type="date" id="to"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="price_offer_sales_table">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.sales.price_offer_sales.modals.create_price_offer_sales')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            price_offer_sales_table_ajax();
        });

        function price_offer_sales_table_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('price_offer_sales_table').innerHTML =
                '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '{{ route('price_offer_sales.price_offer_sales_table_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'customer_id': document.getElementById('customer_id').value,
                    'insert_by': document.getElementById('insert_by').value,
                    'from': document.getElementById('from').value,
                    'to': document.getElementById('to').value,
                },
                success: function(data) {
                    if (data.success == 'true') {
                        $('#price_offer_sales_table').html(data.view);
                    } else if (data.success == 'false') {
                        toastr.error(data.message);
                    }
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
