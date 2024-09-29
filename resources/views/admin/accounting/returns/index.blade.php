@extends('home')
@section('title')
    مردودات الفواتير
@endsection
@section('header_title')
    مردودات الفواتير
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
مردودات الفواتير
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
            <div class="small-box bg-light text-white border border-dark">
                <div class="inner">
                    <div class="row">
                        <div class="col-md-3">
                            <h4 class="text-bold text-dark m-1">مردودات المبيعات والمشتريات</h4>
                        </div>
                        <div class="col-md-9">
                            <div class="row ml-2 w-100">
                                <button class="btn btn-sm btn-dark col-md-3 col-12 m-1 p-2" onclick="return_modal('sales')"><span class="fa fa-file"></span>&nbsp;&nbsp;<span>اضافة مردود مبيعات</span></button>
                                <button class="btn btn-dark btn-sm col-md-3 col-12 m-1 p-2" onclick="return_modal('purchases')"><span class="fa fa-file-text"></span>&nbsp;&nbsp;<span>اضافة مردود مشتريات</span></button>                                   
                            </div>
                        </div>
                    </div>
                    {{-- <h3>{{ $order_count }}</h3> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <input onkeyup="returns_table(1)" type="text" id="reference_number" class="form-control" placeholder="بحث عن الرقم المرجعي">
                            </div>
                        </div>
                        <div class="col-md-2 d-flex justify-content-between">
                            <div class="form-group">
                                <input checked onchange="returns_table(1)" name="radio_invoice_type" class="radio_invoice_type" value="sales" id="sales_radio_button" type="radio">
                                <label for="sales_radio_button">مبيعات</label>
                            </div>
                            <div class="form-group">
                                <input onchange="returns_table(1)" name="radio_invoice_type" class="radio_invoice_type" value="purchase" id="purchase_radio_button" type="radio">
                                <label for="purchase_radio_button">مشتريات</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div id="returns_table">
        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    @include('admin.accounting.returns.modals.createReturns')
    @include('admin.accounting.returns.modals.createReturnsPurchases')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>

        $(document).ready(function () {
            returns_table(1);
        });

        $(document).ready(function () {
            $('.invoice_radio').on('change',function () {
                if($(this).val() === 'invoice'){
                    $('#with_invoice').css('display','block')
                    $('#with_not_invoice').css('display','none')
                    $('#returns_type_invoice').val('with_invoice');
                }
                else{
                    $('#with_not_invoice').css('display','block');
                    $('#with_invoice').css('display','none');
                    $('#returns_type_invoice').val('with_not_invoice');
                }
            })
        });

        function return_modal(return_type) {
            if(return_type == 'purchases'){
                $('#modal_title').html('اضافة مردود مشتريات');
            }
            else if(return_type == 'sales'){
                $('#modal_title').html('اضافة مردود مبيعات');
            }
            $('#create-returns-modal').modal('show');
            $('#returns_type').val(return_type);
        }

        function get_invoices_for_client(client_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.returns.get_invoices_for_client') }}',
                method: 'post',
                headers: headers,
                data: {
                    'client_id' : client_id,
                },
                success: function (data) {
                    if(data.data.length === 0){
                        alert('لا توجد فواتير')
                        $('#invoice_id').prop('disabled',true);
                    }
                    else{
                        $('#invoice_id').empty();
                        $('#invoice_id').prop('disabled',false);
                        $('#invoice_id').append($('<option>', {
                            value: '',
                            text: 'اختر فاتورة ...'
                        }));
                        $.each(data.data, function(index, item) {
                            $('#invoice_id').append($('<option>', {
                                value: item.id,
                                text: item.bill_date + " | " +   item.invoice_reference_number
                            }));
                        });
                        $('#invoice_id').select2();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function selected_client_with_not_invoices(value) {

            if (value !== ''){
                $('#product_form_search').css('display','block');
                product_table('');
            }
            else{
                $('#product_form_search').css('display','none');
            }
        }

        function get_invoice_items(invoice_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.returns.get_invoice_items') }}',
                method: 'post',
                headers: headers,
                data: {
                    'invoice_id' : invoice_id,
                },
                success: function (data) {
                    $('#invoice_id_input_hidden').val(invoice_id);
                    invoice_items_table(invoice_id);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function invoice_items_table(invoice_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.returns.invoice_items_table') }}',
                method: 'post',
                headers: headers,
                data: {
                    'invoice_id' : invoice_id,
                },
                success: function (data) {
                    $('#invoice_items_table').html(data.view);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function product_table(search) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.returns.invoice_items_table') }}',
                method: 'post',
                headers: headers,
                data: {
                    'search' : search,
                },
                success: function (data) {
                    $('#product_table').html(data.view);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function returns_table(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route("accounting.returns.returns_table_ajax") }}',
                type: 'POST',
                headers: headers,
                data: {
                    page: page ,
                    'reference_number' : $('#reference_number').val(),
                    'radio_invoice_type' : $('.radio_invoice_type:checked').val()
                },
                success: function(response) {
                    console.log(response);
                    $('#returns_table').html(response.view);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        $(document).ready(function () {
            $('#create_return_form').submit(function (event) {
                if($('input[name="selected_products[]"]:checked').length === 0){
                    alert('يجب على الاقل اختيار منتج واحد');
                    event.preventDefault();
                }
            })
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            returns_table(page);
        });
        // var page = 1;
        // $(document).on('click', '.pagination a', function(event){
        //     event.preventDefault();
        //     page = $(this).attr('href').split('page=')[1];
        //     search_order_ajax(page)
        //     invoice_table_index_ajax(page);
        // });
    </script>

    <script>
        $(function(){
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection

