@extends('home')
@section('title')
    اصناف عروض اسعار البيع
@endsection
@section('header_title')
    اصناف عروض اسعار البيع
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    اصناف عروض اسعار البيع
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
{{--    <button type="button" class="btn btn-dark mb-2" data-toggle="modal" data-target="#product_search_modal">اضافة صنف--}}
{{--    </button>--}}
    <button type="button" class="btn btn-dark mb-2" onclick="show_form_product()">اضافة صنف
    </button>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <span>السادة : <span>{{ $price_offer_sales->user->name }}</span></span>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">العملة : </label>
                                <select onchange="update_currency_notes_customer_for_price_offer_sales_items_ajax(this.value,'currency')" name="" id="">
                                    @foreach($currency as $key)
                                        <option @if($key->id == $price_offer_sales->currency_id) selected @endif value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-dark" style="float: left" data-toggle="modal" data-target="#language_print_pdf"><span class="fa fa-print"></span></button>
                    <button class="btn btn-warning mr-2" onclick="add_price_offer_sales_to_order_sales({{ $price_offer_sales->id }})" style="float: left">اضافة طلبية بيع من عرض السعر هذا</button>
                </div>
{{--                <div class="col-md-4">--}}
{{--                    <a target="_blank" style="float: left" href="{{ route('price_offer_sales.price_offer_sales_items.price_offer_sales_items_pdf',['id'=>$price_offer_sales]) }}" class="btn btn-dark"><span class="fa fa-print"></span></a>--}}
{{--                </div>--}}
            </div>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="price_offer_sales_items_table">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">الملاحظات</label>
                        <textarea onchange="update_currency_notes_customer_for_price_offer_sales_items_ajax(this.value,'notes')" class="form-control" name="" id="" cols="30" rows="3">{{ $price_offer_sales->notes }}</textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="language_print_pdf">
        <div class="modal-dialog modal-default">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة صنف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('price_offer_sales.price_offer_sales_items.price_offer_sales_items_pdf') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $price_offer_sales->id }}">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="">اختر اللغة</label>
                                <select class="form-control" required name="language" id="">
                                    <option value="">اختر لغة ...</option>
                                    <option value="ar">عربي</option>
                                    <option value="en">انجليزي</option>
                                    <option value="he">عبري</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-2">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('admin.sales.price_offer_sales.price_offer_sales_items.modals.product_search')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            document.getElementById('form_product').style.display = 'none';
            product_list_search(page);
            price_offer_sales_items_table_ajax(page);
        });

        function show_form_product() {
            document.getElementById('form_product').classList.add('show');
            document.getElementById('form_product').style.display = 'block';
        }

        function close_form_product() {
            document.getElementById('form_product').classList.remove('show');
            document.getElementById('form_product').style.display = 'none';
        }

        function product_list_search(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('price_offer_sales.price_offer_sales_items.product_list_search') }}',
                method: 'post',
                headers: headers,
                data: {
                    'price_offer_sales_id':{{ $price_offer_sales->id }},
                    'product_search': document.getElementById('product_search').value,
                    'page': page
                },
                success: function(data) {
                    $('#product_list_search').html(data.view);
                    // toastr.success('تم تعديل الوحدة بنجاح')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function price_offer_sales_items_table_ajax(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('price_offer_sales.price_offer_sales_items.price_offer_sales_items_table_ajax') }}',
                method: 'post',
                method: 'post',
                headers: headers,
                data: {
                    'price_offer_sales_id':{{ $price_offer_sales->id }},
                    'page':page,
                },
                success: function(data) {
                    $('#price_offer_sales_items_table').html(data.view)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function create_price_offer_sales_items_ajax(product_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('price_offer_sales_items_table').innerHTML =
                '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '{{ route('price_offer_sales.price_offer_sales_items.create_price_offer_sales_items_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'price_offer_sales_id':{{ $price_offer_sales->id }},
                    'product_id': product_id,
                },
                success: function(data) {
                    if(data.success == 'true'){
                        toastr.success(data.message);
                        product_list_search(page);
                        price_offer_sales_items_table_ajax(page);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function delete_price_offer_sales_items(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('price_offer_sales_items_table').innerHTML =
                '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '{{ route('price_offer_sales.price_offer_sales_items.delete_price_offer_sales_items') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id':id,
                },
                success: function(data) {
                    console.log(data);
                    if(data.success == 'true'){
                        toastr.success(data.message);
                        product_list_search(page);
                        price_offer_sales_items_table_ajax(page)
                    }
                    else if(data.success == 'false'){
                        toastr.error(data.message);
                        product_list_search(page);
                        price_offer_sales_items_table_ajax(page)
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function add_price_offer_sales_to_order_sales(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.orders_sales.add_price_offer_sales_to_order_sales') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id':id,
                    'customer_id' : {{ $price_offer_sales->customer_id }},
                    'price_offer_sales_id' : id
                },
                success: function(data) {
                    // console.log(data.redirect);
                    window.location.href = data.redirect;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_qty_price_price_offer_sales_items_ajax(id,value,operation) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById(`loader_${operation}_${id}`).style.display = 'inline';
            $.ajax({
                url: '{{ route('price_offer_sales.price_offer_sales_items.update_qty_price_price_offer_sales_items_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id':id,
                    'operation': operation,
                    'value':value
                },
                success: function(data) {
                    console.log(data);
                    if(data.success == 'true'){
                        toastr.success(data.message);
                        price_offer_sales_items_table_ajax(page);
                        // get_sum_price_offer_sales_items_ajax();
                    }
                    else if(data.success == 'false'){
                        toastr.error(data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_currency_notes_customer_for_price_offer_sales_items_ajax(value,operation) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('price_offer_sales.price_offer_sales_items.update_currency_notes_customer_for_price_offer_sales_items_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'price_offer_sales_id': {{ $price_offer_sales->id }},
                    'operation': operation,
                    'value':value
                },
                success: function(data) {
                    console.log(data);
                    if(data.success == 'true'){
                        toastr.success(data.message);
                    }
                    else if(data.success == 'false'){
                        toastr.error(data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function get_sum_price_offer_sales_items_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('price_offer_sales.price_offer_sales_items.get_sum_price_offer_sales_items_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'price_offer_sales_id': {{ $price_offer_sales->id }},
                },
                success: function(data) {
                    if(data.success == 'true'){
                        document.getElementById('sum_items').innerText = data.sum;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        var page = 1;
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            product_list_search(page);
            price_offer_sales_items_table_ajax(page);
        });

    </script>

    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection

