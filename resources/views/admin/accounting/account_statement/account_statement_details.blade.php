@extends('home')
@section('title')
    تفاصيل حساب المستخدم
@endsection
@section('header_title')
    تفاصيل حساب المستخدم
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    تفاصيل حساب المستخدم
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    @if ($user_type == 'customer')
                        <p>كشف حساب زبون : <span>{{ $user->name }}</span></p>
                        <p>كشف حساب عميل تقرير بجميع المعاملات المالية للزبون</p>
                    @elseif($user_type == 'supplier')
                        <p>كشف حساب مورد : <span>{{ $user->name }}</span></p>
                        <p>كشف حساب عميل تقرير بجميع المعاملات المالية للمورد</p>
                    @endif
                </div>
                <div class="col-md-2">
                    <button data-toggle="modal" data-target="#open_print_modal"
                    class="btn btn-dark float-right"><span class="fa fa-print"></span></button>

                    {{-- <a target="_blank"
                        href="{{ route('accounting.account-statement.print_account_statement_details_pdf', ['user_id' => $user->id]) }}"
                        class="btn btn-dark float-right"><span class="fa fa-print"></span></a> --}}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="">المستند</label>
                        <input type="text" onkeyup="account_statement_details_table_ajax()" id="reference_number"
                            class="form-control" placeholder="بحث عن مستند">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">من تاريخ</label>
                        <input onchange="account_statement_details_table_ajax()" id="from" type="date"
                            class="form-control" placeholder="من تاريخ">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">الى تاريخ</label>
                        <input onchange="account_statement_details_table_ajax()" id="to" type="date"
                            class="form-control" placeholder="الى تاريخ">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">اساس الاستحقاق</label>
                        <select name="" id="" class="form-control">
                            <option value="">الكل</option>
                            <option value="">عرض الإيرادات المحققة</option>
                            <option value="">عرض المصروفات المستحقة</option>
                            <option value="">الإيرادات المؤجلة</option>
                            <option value="">المصروفات المؤجلة</option>
                            <option value="">الفواتير المستحقة</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">اساس النقدية</label>
                        <select name="" id="" class="form-control">
                            <option value="">الكل</option>
                            <option value="">الإيرادات المستلمة نقدًا</option>
                            <option value="">المصروفات المدفوعة نقدًا</option>
                            <option value="">الإيرادات النقدية المؤكدة</option>
                            <option value="">المصروفات النقدية المؤكدة</option>
                            <option value="">الدفعات النقدية</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">نوع كشف الحساب</label>
                        <select onchange="account_statement_details_table_ajax()" name="" id="statement_type" class="form-control">
                            <option value="normal">عادي</option>
                            <option value="detailed">مفصل</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="account_statement_details_table">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.accounting.account_statement.modals.language_print')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            account_statement_details_table_ajax();

            $('#statement_type').on('change', function() {
                $('#statement_type_print').val($(this).val());
            });
        });

        function account_statement_details_table_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.account-statement.account_statement_details_table_ajax') }}',
                method: 'POST',
                header: headers,
                data: {
                    '_token': csrfToken,
                    'user_id': {{ $user->id }},
                    'reference_number': $('#reference_number').val(),
                    'from': $('#from').val(),
                    'to': $('#to').val(),
                    'account_statment_type': $('#statement_type').val(),
                },
                success: function(data) {
                    console.log(data);
                    $('#account_statement_details_table').html(data.view);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);
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
