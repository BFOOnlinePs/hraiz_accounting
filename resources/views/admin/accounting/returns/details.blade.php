@extends('home')
@section('title')
    تفاصيل المردود
@endsection
@section('header_title')
    تفاصيل المردود
@endsection
@section('header_link')
    مردود المبيعات
@endsection
@section('header_title_link')
    تفاصيل المردود
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>تفاصيل المردود</h5>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-xs text-center table-rounded">
                                <thead class="thead-light">
                                    <tr>
                                        <th>اسم العميل</th>
                                        <th>تاريخ الفاتورة</th>
                                        <th>نوع الفاتورة</th>
                                        <th>نوع المردود</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $data->invoice->client->name ?? '' }}</td>
                                        <td>{{ $data->invoice->created_at }}</td>
                                        <td>نوع المردود</td>
                                        <td>
                                            @if($data->returns_type == 'sales')
                                                <span class="w-100 badge badge-success">مبيعات</span>
                                            @else
                                                <span class="w-100 badge badge-warning">مشتريات</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if($data->status == 'stage')
                                <div class="alert alert-success">
                                    تم ترحيل هذه الفاتورة
                                </div>
                            @endif
                            <h6>الرقم المرجعي لمردود المبيعات : <span>{{ $data->invoice->invoice_reference_number }}</span></h6>
                            <span><button onclick="window.location.href='{{ route('accounting.returns.returns_pdf',['id'=>$data->id]) }}'" class="btn btn-warning mr-1 float-right"><i class="fa fa-print"></i></button></span>
                            <span>المنتجات المردودة <button @if($data->status == 'stage') disabled @endif onclick="window.location.href='{{ route('accounting.returns.invoice_posting',['id'=>$data->id]) }}'" class="btn btn-info float-right">ترحيل</button></span>
                            <hr>
                            <div class="table-responsive">
                                <div id="return_item_table">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control" onkeyup="product_table(this.value)" placeholder="بحث عن صنف">
                            <div class="table-responsive">
                                <div id="product_table">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            product_table('');
            return_item_table();
        });

        function product_table(search_input) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.returns.product_table') }}',
                method: 'post',
                headers: headers,
                data: {
                    'search_input' : search_input,
                    'invoice_id' : {{ $data->invoice_id }},
                    'return_id' : {{ $data->id }}
                },
                success: function (response) {
                    console.log(response);
                    $('#product_table').html(response.view);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function return_item_table() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.returns.return_item_table') }}',
                method: 'post',
                headers: headers,
                data: {
                    'return_id' : {{ $data->id }}
                },
                success: function (response) {
                    console.log(response);
                    $('#return_item_table').html(response.view);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function selected_product_from_search(invoice_id,product_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.returns.selected_product_from_search') }}',
                method: 'post',
                headers: headers,
                data: {
                    'invoice_id' : invoice_id,
                    'product_id' : product_id
                },
                success: function (response) {
                    console.log(response);
                    return_item_table();
                    product_table('');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function remove_item_from_return_items(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.returns.remove_item_from_return_items') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id' : id
                },
                success: function (response) {
                    return_item_table();
                    product_table('');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_qty_from_return_items(id,qty,invoice_qty,inputElement) {
            if(qty > invoice_qty){
                toastr.error('يجب ان تكون الكمية اقل من الكمية الموجودة في الفاتورة');
                $(inputElement).val('');
                $(inputElement).focus();
            }
            else{
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '{{ route('accounting.returns.update_qty_from_return_items') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'id' : id,
                        'qty' : qty
                    },
                    success: function (response) {
                        toastr.success(response.message);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            }
        }

        function update_wherehouse(id,wherehouse_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.returns.update_wherehouse') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id' : id,
                    'wherehouse_id' : wherehouse_id,
                },
                success: function (response) {

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
    </script>
@endsection

