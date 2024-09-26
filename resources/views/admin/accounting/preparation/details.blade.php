@extends('home')
@section('title')
    تفاصيي التحضير
@endsection
@section('header_title')
تفاصيي التحضير
@endsection
@section('header_link')
    التحضير
@endsection
@section('header_title_link')
تفاصيي التحضير
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="from-group">
                                        <label for="">الرقم المرجعي لطلبية البيع</label>
                                        {{-- <input @if($data->order_status == 'invoice_has_been_posted') disabled @endif type="text" onchange="update_orders_sales({{ $data->id }},'reference_number',this.value)" class="form-control" value="{{ $data->reference_number }}"> --}}
                                        <input type="text" class="form-control" disabled value="{{ $data->reference_number }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="from-group">
                                        <label for="">حالة طلبية التحضير</label>
                                        <select class="select2bs4 form-control" onchange="update_data('status',this.value)" name="" id="">
                                            <option value="">اختر الحالة ...</option>
                                            <option @if($preparation->status == 'waiting_prepared') selected @endif value="waiting_prepared">بانتظار التجهيز</option>
                                            <option @if($preparation->status == 'ready_prepared') selected @endif value="ready_prepared">تم التجهيز</option>
                                            <option @if($preparation->status == 'delivered') selected @endif value="delivered">تم التسليم</option>
                                        </select>
                                        {{-- Mohamad Maraqa --}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">ملاحظات المستخدم</label>
                                        <textarea name="" class="form-control" id="" onchange="update_data('notes',this.value)" cols="30" rows="3">{{ $preparation->notes }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">ملاحظات طلبية التحضير</label>
                                        <textarea name="" class="form-control" id="" onchange="update_data('notes_preparation',this.value)" cols="30" rows="3">{{ $preparation->notes_preparation }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-2">
                            <form action="{{ route('accounting.orders_sales.update_order_sales_status') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <button @if($data->order_status == 'invoice_has_been_posted') disabled @endif class="btn btn-info form-control" style="height: 100%">
                                    <span class="text-success">@if($data->order_status == 'invoice_has_been_posted') <span class="fa fa-check-circle"></span> @endif</span>
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
                    <div class='table-responsive'>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>اسم المنتج</th>
                                    <th>الكمية</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data->order_sales_items->isEmpty())
                                    <tr>
                                        <td colspan="2" class="text-center">لا توجد بيانات</td>
                                    </tr>
                                @else
                                    @foreach ($data->order_sales_items as $key)
                                        <tr>
                                            <td>{{ $key->product->product_name_ar }}</td>
                                            <td>{{ $key->qty }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

        function update_data(data_type,value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.preparation.update_data') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id':{{ $data->id }},
                    'data_type' : data_type,
                    'value' : value
                },
                success: function (data) {
                    
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
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

