@extends('home')
@section('title')
    سند صرف
@endsection
@section('header_title')
    سند صرف
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    سند صرف
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
            <button class="btn btn-dark" onclick="view_invoice_type()">اضافة سند صرف
            </button>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">الرقم المرجعي</label>
                        <input onkeyup="performance_bonds_table_ajax()" class="form-control" id="reference_number" type="text"
                               placeholder="الرقم المرجعي">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">نوع الدفعة</label>
                        <select onchange="performance_bonds_table_ajax()" class="form-control" name="" id="payment_type">
                            <option value="">جميع انواع الدفع</option>
                            <option value="cash">كاش</option>
                            <option value="check">شيك</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">اضيفت بواسطة</label>
                        <select class="form-control" onchange="performance_bonds_table_ajax()" name="" id="insert_by">
                            <option value="">جميع المستخدمين</option>
                            @foreach($users as $key)
                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">العميل</label>
                        <select onchange="performance_bonds_table_ajax()" class="form-control select2bs4" name="" id="client_id">
                            <option value="">جميع العملاء ...</option>
                            @foreach($clients as $key)
                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12" id="performance_bonds_table">
                            <div class="table-responsive">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.accounting.bonds.performance_bond.modals.create_payment_bond_modal')
    @include('admin.accounting.bonds.performance_bond.modals.update_check_payment_type')
    @include('admin.accounting.bonds.performance_bond.modals.create_payment_bond_for_client_modal')
    @include('admin.accounting.bonds.performance_bond.modals.list_invoice_type')
    @include('admin.accounting.bonds.performance_bond.modals.list_invoice_clients')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>

        $(document).ready(function () {
            performance_bonds_table_ajax();
        });

        $(document).on('click', '#pagination a', function (e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            list_invoice_for_performance_bond_clients_table_ajax(page);
        });

        function list_invoice_for_performance_bond_clients_table_ajax(page = 1,reference_number = '',client_name = '') {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('bonds.list_invoice_for_performance_bond_clients_table_ajax') }}' + '?page=' + page,
                method: 'post',
                headers: headers,
                data:{
                    reference_number: reference_number,
                    client_name:client_name
                },
                success: function (data) {
                    $('#list_invoice_users').html(data.view);
                    $('#pagination').html(data.pagination);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error fetching data');
                }
            });
        }


        $('input[name="customRadio"]').on('change', function () {
            if ($(this).val() === 'check') {
                $('#check_information').show();
                $('#check_information_client').show();
                $('#checkNumber').prop('required',true);
                $('#due_date').prop('required',true);
                $('#bank_name').prop('required',true);
            } else {
                $('#check_information').hide();
                $('#check_information_client').hide();
            }
        })

        function performance_bonds_table_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.bonds.performance_bond.performance_bonds_table_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'reference_number': $('#reference_number').val(),
                    'payment_type': $('#payment_type').val(),
                    'insert_by': $('#insert_by').val(),
                    'client_id': $('#client_id').val()
                },
                success: function (data) {
                    $('#performance_bonds_table').html(data.view)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        $(document).ready(function () {
            $('#check_create_form').submit(function (e) {
                e.preventDefault();
                var form_data = $(this).serialize();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '{{ route('bonds.update_check_information') }}',
                    method: 'post',
                    headers: headers,
                    data: form_data,
                    success: function (data) {
                        performance_bonds_table_ajax();
                        $('#update_check_payment_type_modal').modal('hide');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            });
        });
        function update_check_information() {

        }

        function get_check_data(data) {
            $('#check_number_edit').val(data.check_number);
            $('#due_date_edit').val(data.due_date);
            $('#bank_name_edit').val(data.bank_name);
            $('#check_status').val(data.check_status);
            $('#bonds_id').val(data.id);
            $('#update_check_payment_type_modal').modal('show');
        }

        function get_amount_for_invoice() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('bonds.get_amount_for_invoice') }}',
                method: 'post',
                headers: headers,
                data: {
                    'invoice_id': $('#invoice_select').val(),
                },
                success: function (data) {
                    $('#invoice_amount').val(data.data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });

        }

        $('.input_serach').on('input', function () {
            var client_name = $('#input_search_clients').val()
            var reference_number = $('#input_search_reference_number').val()
            list_invoice_clients_table_ajax(1,reference_number,client_name); // Call the function with page 1 and the search query
        });

        function view_invoice_type(){
            $('#list_invoice_type').modal('show');
        }

        function view_create_payment_bond_modal() {
            $('#list_invoice_type').modal('hide');
            $('#create_payment_bond_modal').modal('show');
        }

        function view_create_payment_bond_for_client_modal() {
            $('#list_invoice_type').modal('hide');
            $('#create_payment_bond_for_client_modal').modal('show');
        }

        function list_invoice_clients_modal() {
            list_invoice_for_performance_bond_clients_table_ajax();
            $('#list_invoice_type').modal('hide');
            $('#list_invoice_clients_modal').modal('show');
        }

        function select_get_invoice_number_from_select_invoice(value) {
            $('#invoice_select').val(value);
            $('#list_invoice_clients_modal').modal('hide');
            view_create_payment_bond_modal();
        }
    </script>

    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection

