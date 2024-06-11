@extends('home')
@section('title')
    سند قيد
@endsection
@section('header_title')
    سند قيد
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    سند قيد
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
            <button class="btn btn-dark" data-toggle="modal" data-target="#add_registration_modal">اضافة سند قيد</button>
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
{{--                            @foreach($users as $key)--}}
{{--                                <option value="{{ $key->id }}">{{ $key->name }}</option>--}}
{{--                            @endforeach--}}
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">العميل</label>
                        <select onchange="performance_bonds_table_ajax()" class="form-control select2bs4" name="" id="client_id">
                            <option value="">جميع العملاء ...</option>
{{--                            @foreach($clients as $key)--}}
{{--                                <option value="{{ $key->id }}">{{ $key->name }}</option>--}}
{{--                            @endforeach--}}
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
                        <div class="col-md-12" id="registration_bonds_list">
                            <div class="table-responsive">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.accounting.bonds.registration_bonds.modals.add_registration_modal')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>

        $(document).ready(function () {
            registration_bonds_list_ajax();
        });

        $(document).on('click', '#pagination a', function (e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            // list_invoice_for_performance_bond_clients_table_ajax(page);
        });

        function registration_bonds_list_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.bonds.registration_bonds.registration_bonds_list_ajax') }}',
                method: 'post',
                headers: headers,
                data:{
                    // reference_number: reference_number,
                    // client_name:client_name
                },
                success: function (data) {
                    // alert('success');
                    $('#registration_bonds_list').html(data.view);
                    // $('#pagination').html(data.pagination);
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
    </script>

    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection

