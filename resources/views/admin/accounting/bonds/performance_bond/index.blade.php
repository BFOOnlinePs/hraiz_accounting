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
    <style>
        #modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        #modal img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
        }
    </style>
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <input type="hidden" id="pageType">
    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="small-box bg-dark text-white border border-dark">
                <div class="inner">
                    <div class="row">
                        <div class="col-md-3">
                            <h4 class="text-bold m-1">سندات الصرف</h4>
                        </div>
                        <div class="col-md-9">
                            <div class="row ml-2 w-100">
                                <button class="btn btn-sm btn-light col-md-3 col-12 m-1 p-2" onclick="view_invoice_type()">
                                    <span class="fa fa-plus"></span>
                                    &nbsp;
                                    <span>اضافة سند صرف</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- <h3>{{ $order_count }}</h3> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">الرقم المرجعي</label>
                        <input onkeyup="performance_bonds_table_ajax()" class="form-control" id="reference_number"
                            type="text" placeholder="الرقم المرجعي">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">نوع الدفعة</label>
                        <select onchange="performance_bonds_table_ajax()" class="form-control" name=""
                            id="payment_type">
                            <option value="">جميع انواع الدفع</option>
                            <option value="cash">كاش</option>
                            <option value="check">شيك</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">اضيفت بواسطة</label>
                        <select class="form-control" onchange="performance_bonds_table_ajax()" name=""
                            id="insert_by">
                            <option value="">جميع المستخدمين</option>
                            @foreach ($users as $key)
                                <option value="{{ $key->id }}">{{ $key->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">العميل</label>
                        <select onchange="performance_bonds_table_ajax()" class="form-control select2bs4" name=""
                            id="client_id">
                            <option value="">جميع العملاء ...</option>
                            @foreach ($clients as $key)
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
    @include('admin.accounting.bonds.performance_bond.modals.search_check')
    @include('admin.accounting.bonds.performance_bond.modals.view_image')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            performance_bonds_table_ajax();
        });

        $(document).on('click', '#pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            list_invoice_for_performance_bond_clients_table_ajax(page);
        });

        function list_invoice_for_performance_bond_clients_table_ajax(page = 1, reference_number = '', client_name = '') {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('bonds.list_invoice_for_performance_bond_clients_table_ajax') }}' + '?page=' + page,
                method: 'post',
                headers: headers,
                data: {
                    reference_number: reference_number,
                    client_name: client_name
                },
                success: function(data) {
                    $('#list_invoice_users').html(data.view);
                    $('#pagination').html(data.pagination);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error fetching data');
                }
            });
        }


        $('input[name="customRadio"]').on('change', function() {
            if ($(this).val() === 'check') {
                $('#check_information').show();
                $('#check_information_client').show();
                $('#checkNumber').prop('required', true);
                $('#due_date').prop('required', true);
                $('#bank_name').prop('required', true);
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
                success: function(data) {
                    $('#performance_bonds_table').html(data.view)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        $(document).ready(function() {
            $('#check_create_form').submit(function(e) {
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
                    success: function(data) {
                        performance_bonds_table_ajax();
                        $('#update_check_payment_type_modal').modal('hide');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            });
        });

        function update_check_information() {

        }

        function get_check_data(data) {
            var frontImageUrl = "{{ asset('storage') }}" + '/' + data.front_image;
            var rearImageUrl = "{{ asset('storage') }}" + '/' + data.rear_image;
            $('#check_number_edit').val(data.check_number);
            $('#due_date_edit').val(data.due_date);
            $('#bank_name_edit').val(data.bank.user_bank_name);
            $('#check_status').val(data.check_status);
            $('#front_check_edit').attr('src', frontImageUrl);
            $('#rear_check_edit').attr('src', rearImageUrl);
            // alert(data.front_image);
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
                success: function(data) {
                    $('#invoice_amount').val(data.data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });

        }

        $('.input_serach').on('input', function() {
            var client_name = $('#input_search_clients').val()
            var reference_number = $('#input_search_reference_number').val()
            list_invoice_clients_table_ajax(1, reference_number,
                client_name); // Call the function with page 1 and the search query
        });

        function view_invoice_type() {
            $('#list_invoice_type').modal('show');
        }

        function view_create_payment_bond_modal() {
            $('#list_invoice_type').modal('hide');
            $('#create_payment_bond_modal').modal('show');
        }

        function view_create_payment_bond_for_client_modal() {
            $('#pageType').val('add_check_div_client');
            $('#list_invoice_type').modal('hide');
            $('#create_payment_bond_for_client_modal').modal('show');
        }

        function list_invoice_clients_modal() {
            $('#pageType').val('add_check_div_general');
            list_invoice_for_performance_bond_clients_table_ajax();
            $('#list_invoice_type').modal('hide');
            $('#list_invoice_clients_modal').modal('show');
        }

        function select_get_invoice_number_from_select_invoice(value) {
            console.log(value);

            $('#invoice_select').val(value.id);
            $('#invoice_amount').val(value.total_amount);
            $('#list_invoice_clients_modal').modal('hide');
            view_create_payment_bond_modal();
        }

        function checkIfDivIsEmpty() {
            if ($('#add_check_div').is(':empty') || $('#add_check_client_div').is(':empty')) {
                $('#submit_button').hide();
                $('#submit_button_client').hide();
            } else {
                $('#submit_button').show();
                $('#submit_button_client').show();
            }
        }

        let checkIndex = 0;

        function add_check_for_client(data) {
            const currencies = @json($currencies);
            const banks = @json($banks);
            const clients = @json($clients);
            let currencyOptions = currencies.map(currency =>
                `<option ${currency.id === data.currency ? 'selected' : ''} value="${currency.id}">${currency.currency_name}</option>`
            ).join('');
            let clientsOptions = clients.map(client =>
                `<option ${client.id === data.clinet_id ? 'selected' : ''} value="${client.id}">${client.name}</option>`
            ).join('');
            let banksOptions = banks.map(bank =>
                `<option ${bank.id === data.bank_id ? 'selected' : ''} value="${bank.id}">${bank.user_bank_name}</option>`
            ).join('');

            $('#add_check_for_client_div').append(
                '<div class="col-md-12 mb-3 card-container" data-index="' + checkIndex + '">' +
                '<div class="card">' +
                '<div class="card-header d-flex justify-content-between align-items-center">' +
                '<h5 class="mb-0">شيك جديد</h5>' +
                '<button type="button" class="btn btn-sm btn-danger delete-check-btn" title="حذف الشيك">' +
                '<i class="fas fa-x"></i>' +
                '</button>' +
                '</div>' +
                '<div class="card-body">' +
                '<div class="row">' +

                // Check Number Field
                '<div class="col-md-4">' +
                '<div class="form-group">' +
                '<label for="">رقم الشيك</label>' +
                '<input required type="text" value="' + (data.check_number || '') +
                '" name="checks[' + checkIndex + '][check_number]" class="form-control">' +
                '</div>' +
                '</div>' +

                // Due Date Field
                '<div class="col-md-4">' +
                '<div class="form-group">' +
                '<label for="">تاريخ الاستحقاق</label>' +
                '<input required type="date" value="' + (data.due_date || '') +
                '" name="checks[' + checkIndex + '][due_date]" class="form-control">' +
                '</div>' +
                '</div>' +

                // Bank Name Field
                '<div class="col-md-4">' +
                '<div class="form-group">' +
                '<label for="">اسم البنك</label>' +
                '<select name="checks[' + checkIndex + '][bank_id]" class="form-control select2bs4">' +
                banksOptions +
                '</select>' +
                '</div>' +
                '</div>' +

                // Currency Field
                '<div class="col-md-4">' +
                '<div class="form-group">' +
                '<label for="">العملة</label>' +
                '<select name="checks[' + checkIndex + '][currency_id]" class="form-control">' +
                currencyOptions +
                '</select>' +
                '</div>' +
                '</div>' +

                // Amount Field
                '<div class="col-md-4">' +
                '<div class="form-group">' +
                '<label for="">القيمة</label>' +
                '<input required type="text" value="' + (data.amount || '') +
                '" name="checks[' + checkIndex + '][amount]" class="form-control">' +
                '</div>' +
                '</div>' +

                // Notes Field
                '<div class="col-md-4">' +
                '<div class="form-group">' +
                '<label for="">الملاحظات</label>' +
                '<input type="text" value="' + (data.notes || '') +
                '" name="checks[' + checkIndex + '][notes]" class="form-control">' +
                '</div>' +
                '</div>' +

                // Front Image Field
                '<div class="col-md-4">' +
                '<div class="form-group">' +
                '<label for="">صورة الوجه الأمامي</label>' +
                '<input type="file" name="checks[' + checkIndex +
                '][front_image]" accept="image/*" class="form-control">' +
                '</div>' +
                '</div>' +

                // Rear Image Field
                '<div class="col-md-4">' +
                '<div class="form-group">' +
                '<label for="">صورة الوجه الخلفي</label>' +
                '<input type="file" name="checks[' + checkIndex +
                '][rear_image]" accept="image/*" class="form-control">' +
                '</div>' +
                '</div>' +

                '</div>' + // Close row
                '</div>' + // Close card-body
                '</div>' + // Close card
                '</div>' // Close col-md-12
            );

            // Attach event handler for delete button
            $('#add_check_for_client_div').on('click', '.delete-check-btn', function() {
                $(this).closest('.card-container').remove();
                checkIfDivIsEmpty();
            });

            checkIfDivIsEmpty();

            checkIndex++; // Increment the index for each new check
        }

        function add_check(data) {
            checkIfDivIsEmpty();
            const currencies = @json($currencies);
            const banks = @json($banks);
            const clients = @json($clients);
            let currencyOptions = currencies.map(currency =>
                `<option ${currency.id === data.currency ? 'selected' : ''} value="${currency.id}">${currency.currency_name}</option>`
            ).join('');
            let clientsOptions = clients.map(client =>
                `<option ${client.id === data.clinet_id ? 'selected' : ''} value="${client.id}">${client.name}</option>`
            ).join('');
            let banksOptions = banks.map(bank =>
                `<option ${bank.id === data.bank_id ? 'selected' : ''} value="${bank.id}">${bank.user_bank_name}</option>`
            ).join('');

            var pageType = $('#pageType').val();
            if (pageType == 'add_check_div_client') {
                $('#add_check_for_client_div').append(
                    '<div class="col-md-12 mb-3 card-container" data-index="' + checkIndex + '">' +
                    '<div class="card">' +
                    '<div class="card-header d-flex justify-content-between align-items-center">' +
                    '<h5 class="mb-0">شيك جديد</h5>' +
                    '<button type="button" class="btn btn-sm btn-danger delete-check-btn" title="حذف الشيك">' +
                    '<i class="fas fa-x"></i>' +
                    '</button>' +
                    '</div>' +
                    '<div class="card-body">' +
                    '<div class="row">' +

                    // Check Number Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">رقم الشيك</label>' +
                    '<input required type="text" value="' + (data.check_number || '') +
                    '" name="checks[' + checkIndex + '][check_number]" class="form-control">' +
                    '</div>' +
                    '</div>' +

                    // Due Date Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">تاريخ الاستحقاق</label>' +
                    '<input required type="date" value="' + (data.due_date || '') +
                    '" name="checks[' + checkIndex + '][due_date]" class="form-control">' +
                    '</div>' +
                    '</div>' +

                    // Bank Name Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">اسم البنك</label>' +
                    '<select name="checks[' + checkIndex + '][bank_id]" class="form-control select2bs4">' +
                    banksOptions +
                    '</select>' +
                    '</div>' +
                    '</div>' +

                    // Currency Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">العملة</label>' +
                    '<select name="checks[' + checkIndex + '][currency_id]" class="form-control">' +
                    currencyOptions +
                    '</select>' +
                    '</div>' +
                    '</div>' +

                    // Amount Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">القيمة</label>' +
                    '<input required type="text" value="' + (data.amount || '') +
                    '" name="checks[' + checkIndex + '][amount]" class="form-control">' +
                    '</div>' +
                    '</div>' +

                    // Notes Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">الملاحظات</label>' +
                    '<input type="text" value="' + (data.notes || '') +
                    '" name="checks[' + checkIndex + '][notes]" class="form-control">' +
                    '</div>' +
                    '</div>' +

                    // Front Image Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">صورة الوجه الأمامي</label>' +
                    '<input type="file" name="checks[' + checkIndex +
                    '][front_image]" accept="image/*" class="form-control">' +
                    '</div>' +
                    '</div>' +

                    // Rear Image Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">صورة الوجه الخلفي</label>' +
                    '<input type="file" name="checks[' + checkIndex +
                    '][rear_image]" accept="image/*" class="form-control">' +
                    '</div>' +
                    '</div>' +

                    '</div>' + // Close row
                    '</div>' + // Close card-body
                    '</div>' + // Close card
                    '</div>' // Close col-md-12
                );

                // Attach event handler for delete button
                $('#add_check_for_client_div').on('click', '.delete-check-btn', function() {
                    $(this).closest('.card-container').remove();
                    checkIfDivIsEmpty();
                });

            } else {
                $('#add_check_div').append(
                    '<div class="col-md-12 mb-3 card-container" data-index="' + checkIndex + '">' +
                    '<div class="card">' +
                    '<div class="card-header d-flex justify-content-between align-items-center">' +
                    '<h5 class="mb-0">شيك جديد</h5>' +
                    '<button type="button" class="btn btn-sm btn-danger delete-check-btn" title="حذف الشيك">' +
                    '<i class="fas fa-x"></i>' +
                    '</button>' +
                    '</div>' +
                    '<div class="card-body">' +
                    '<div class="row">' +

                    // Check Number Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">رقم الشيك</label>' +
                    '<input required type="text" value="' + (data.check_number || '') +
                    '" name="checks[' + checkIndex + '][check_number]" class="form-control">' +
                    '</div>' +
                    '</div>' +

                    // Due Date Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">تاريخ الاستحقاق</label>' +
                    '<input required type="date" value="' + (data.due_date || '') +
                    '" name="checks[' + checkIndex + '][due_date]" class="form-control">' +
                    '</div>' +
                    '</div>' +

                    // Bank Name Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">اسم البنك</label>' +
                    '<select name="checks[' + checkIndex + '][bank_id]" class="form-control select2bs4">' +
                    banksOptions +
                    '</select>' +
                    '</div>' +
                    '</div>' +

                    // Currency Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">العملة</label>' +
                    '<select name="checks[' + checkIndex + '][currency_id]" class="form-control">' +
                    currencyOptions +
                    '</select>' +
                    '</div>' +
                    '</div>' +

                    // Amount Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">القيمة</label>' +
                    '<input required type="text" value="' + (data.amount || '') +
                    '" name="checks[' + checkIndex + '][amount]" class="form-control">' +
                    '</div>' +
                    '</div>' +

                    // Notes Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">الملاحظات</label>' +
                    '<input type="text" value="' + (data.notes || '') +
                    '" name="checks[' + checkIndex + '][notes]" class="form-control">' +
                    '</div>' +
                    '</div>' +

                    // Front Image Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">صورة الوجه الأمامي</label>' +
                    '<input type="file" name="checks[' + checkIndex +
                    '][front_image]" accept="image/*" class="form-control">' +
                    '</div>' +
                    '</div>' +

                    // Rear Image Field
                    '<div class="col-md-4">' +
                    '<div class="form-group">' +
                    '<label for="">صورة الوجه الخلفي</label>' +
                    '<input type="file" name="checks[' + checkIndex +
                    '][rear_image]" accept="image/*" class="form-control">' +
                    '</div>' +
                    '</div>' +

                    '</div>' + // Close row
                    '</div>' + // Close card-body
                    '</div>' + // Close card
                    '</div>' // Close col-md-12
                );

                // Attach event handler for delete button
                $('#add_check_div').on('click', '.delete-check-btn', function() {
                    $(this).closest('.card-container').remove();
                    checkIfDivIsEmpty();
                });
                checkIfDivIsEmpty();
            }
            checkIndex++; // Increment the index for each new check
        }

        function open_search_check_modal() {
            $('#search_check_modal').modal('show');
            setTimeout(() => {
                $('#search_check_input').focus();
            }, 1000);
        }

        $('#search_check_input').on('keyup', function() {
            var key = $(this).val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.bonds.check.list_check_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'check_number': $(this).val()
                },
                success: function(data) {
                    if (data.success == 'true') {
                        $('#list_checks').html(data.view);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);

                }
            });
        });

        // اختر الصور وحاوية العرض الكبير
        const frontImage = document.getElementById("front_check_edit");
        const rearImage = document.getElementById("rear_check_edit");
        const modal = document.getElementById("list_image_modal");
        const modalImage = document.getElementById("image_modal");

        // عرض الصورة الكبيرة عند الضغط على الصورة الأمامية
        frontImage.onclick = function() {
            $('#list_image_modal').modal('show');
            $('#image_modal').attr('src', frontImage.src);
        }

        // عرض الصورة الكبيرة عند الضغط على الصورة الخلفية
        rearImage.onclick = function() {
            $('#list_image_modal').modal('show');
            $('#image_modal').attr('src', rearImage.src);
        }
    </script>

    <script>
        $(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
