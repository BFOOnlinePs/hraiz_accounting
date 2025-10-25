@extends('home')
@section('title')
    فاتورة مبيعات ({{ $data->invoice_reference_number }})
@endsection
@section('header_title')
    فاتورة مبيعات
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    فاتورة مبيعات
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <style>
        .search_table th {
            text-align: center
        }

        .search_table td {
            text-align: center
        }

        .search_table td input {
            width: 90px;
            text-align: center
        }

        .image-zoom {
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .image-preview-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .image-preview-overlay.show {
            visibility: visible;
            opacity: 1;
        }

        .image-preview-overlay img {
            max-width: 80%;
            max-height: 80%;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
            transition: transform 0.3s ease;
            transform: scale(0.9);
        }

        .image-preview-overlay.show img {
            transform: scale(1);
        }

    </style>
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')

    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="small-box bg-light text-white border border-success">
                <div class="inner">
                    <div class="row">
                        <div class="col-md-7">
                            <h4 class="text-bold text-dark m-1">فاتورة مبيعات # {{ $data->id }} - <span
                                    class="text-danger">{{ $data->invoice_reference_number }}</span></h4>
                        </div>
                        <div class="col-md-5">
                            <div class="row ml-2">
                                <button class="btn btn-sm btn-warning col-md-6 col-12 m-1 p-2" data-toggle="modal"
                                        data-target="#add_print_language_modal"><span class="fa fa-print"></span> &nbsp;&nbsp;
                                    <span>طباعة</span></button>
                                @if ($data->status != 'stage')
                                    <button @if ($data->status == 'stage') disabled @endif onclick="post_the_invoice()"
                                            class="btn btn-sm btn-info col-md-5 col-12 m-1 p-2"><span
                                            class="fa fa-check"></span>&nbsp;&nbsp;<span>ترحيل الفاتورة</span></button>
                                @endif
                                @if ($data->status == 'stage')
                                    <div class="btn btn-sm btn-success col-md-5 col-12 m-1 p-2">
                                        <span class="fa fa-check"></span>

                                        <span>تم ترحيل هذه الفاتورة</span>
                                    </div>
                                @endif
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
                    @if ($data->order_id != null)
                        <div class="row text-center">
                            <div class="col-md-12 alert alert-info">
                                تم انشاء هذه الفاتورة استناداً لطلبية رقم <a
                                    href="{{ route('accounting.orders_sales.orders_sales_details', ['order_id' => $data->order_id]) }}"
                                    class="btn btn-dark btn-sm">{{ $data->order->reference_number ?? '' }}</a> وتم
                                اضافة التاريخ بشكل تلقائي
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md">
                                    <div class="from-group">
                                        <label for="">الرقم المرجعي للفاتورة</label>
                                        <input type="text" @if ($data->status == 'stage') readonly @endif
                                        onchange="update_invoice_reference_number_ajax(this.value)"
                                               class="form-control arabicNumbers"
                                               value="{{ $data->invoice_reference_number }}">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">من</label>
                                        <select disabled name="client_id" id="" class="form-control select2bs4">
                                            <option value="">اختر عميل ...</option>
                                            @foreach ($users as $key)
                                                <option @if ($key->id == $data->client_id) selected @endif
                                                value="{{ $key->id }}">{{ $key->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md">
                                    <div class="form-group">
                                            <?php
                                            $month = date('m');
                                            $day = date('d');
                                            $year = date('Y');
                                            $today = $year . '-' . $month . '-' . $day;
                                            ?>
                                        <label for="">تاريخ الفاتورة</label>
                                        <input @if ($data->status == 'stage') readonly @endif
                                        onchange="update_purchase_invoices_from_ajax('bill_date',this.value)"
                                               type="date" name="bill_date" class="form-control text-center"
                                               value="{{ $data->bill_date }}">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <?php
                                        $month = date('m');
                                        $day = date('d');
                                        $year = date('Y');
                                        $today = $year . '-' . $month . '-' . $day;
                                        ?>
                                        <label for="">تاريخ الاستحقاق</label>
                                        <input @if ($data->status == 'stage') readonly @endif
                                        onchange="update_purchase_invoices_from_ajax('due_date',this.value)"
                                               type="date" name="due_date" class="form-control text-center"
                                               value="{{ $data->due_date }}">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="">العملة</label>
                                        <input type="text" class="form-control" readonly value="{{ $data->currency->currency_name ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div style="display: none" id="recurring_form" class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">التكرار خلال</label>
                                                <input @if ($data->status == 'stage') readonly @endif
                                                onchange="update_purchase_invoices_from_ajax('repeat_every',this.value)"
                                                       value="{{ $data->repeat_every }}" type="text"
                                                       name="repeat_every" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">خلال</label>
                                                <select @if ($data->status == 'stage') disabled @endif
                                                onchange="update_purchase_invoices_from_ajax('repeat_type',this.value)"
                                                        class="form-control" name="repeat_type" id="">
                                                    <option @if ($data->repeat_type == 'days') selected @endif
                                                    value="days">يوم</option>
                                                    <option @if ($data->repeat_type == 'weeks') selected @endif
                                                    value="weeks">اسبوع</option>
                                                    <option @if ($data->repeat_type == 'months') selected @endif
                                                    value="months">شهر</option>
                                                    <option @if ($data->repeat_type == 'years') selected @endif
                                                    value="years">سنة</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">الدورة</label>
                                                <input @if ($data->status == 'stage') readonly @endif
                                                value="{{ $data->no_of_cycles }}" type="text"
                                                       onchange="update_purchase_invoices_from_ajax('no_of_cycles',this.value)"
                                                       name="no_of_cycles" class="form-control" placeholder="الدورة">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($data->status != 'stage')
                        <button onclick="show_form_product()" type="button" id="add_product" class="btn btn-info mb-2">
                            اضافة صنف
                        </button>
                    @endif

                    <div class="row mt-3">
                        <div class="col-md-12">
                            {{-- هذا الـ div سيتم ملؤه بواسطة دالة invoices_table() بالأجاكس --}}
                            <div id="invoices_table">
                                <div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">ملاحظات</label>
                            <textarea style="background-color: #ffbc0773" @if ($data->status == 'stage') readonly @endif class="form-control"
                                      name="note" onchange="update_purchase_invoices_from_ajax('note',this.value)" id="" cols="30"
                                      rows="3">{{ $data->note }}</textarea>
                        </div>
                    </div>
                    <div style="position: fixed; left: 20px; bottom: 20px;height:500px;" id="toastsContainerBottomLeft"
                         class="toasts-bottom-left fixed">
                        <div class="toast border border-success fade" style="background-color:rgba(255,255,255);"
                             id="form_product" role="alert" aria-live="assertive" aria-atomic="true"
                             style="width: 100%; height: 100%;">
                            <div class="toast-header">
                                <strong class="mr-auto">قائمة الأصناف</strong>
                                <button type="button" class="ml-2 mb-1 close" onclick="close_form_product()">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="toast-body">
                                <input type="text" id="search_product" onkeyup="search_product_ajax(this.value)"
                                       class="form-control border border-success" placeholder="بحث عن عنصر">
                                <div style="width: 300px;display:block" class="mt-2">
                                    <div id="search_product_table">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="discount-modal">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('accounting.texes.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">الضريبة</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">قيمة الضريبة</label>
                                    <select class="form-control" name="" id="tax_ratio">
                                        <option value="">لا يوجد ضريبة</option>
                                        @foreach ($taxes as $key)
                                            <option @if ($key->id == $data->tax_id) selected @endif
                                            value="{{ $key->id }}">{{ $key->tax_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">نوع الضريبة</label>
                                    <select class="form-control" name="tax_type" id="tax_type">
                                        <option value="after" @if( ($data->tax_type ?? 'after') == 'after') selected @endif>الضريبة تضاف على المجموع</option>
                                        <option value="before" @if($data->tax_type == 'before') selected @endif>الاسعار شامل الضريبة</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                        <button onclick="update_tax_id_ratio()" type="button" class="btn btn-primary">حفظ</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    @include('admin.accounting.sales_invoices.invoices.modals.print_language')
@endsection()

@section('script')
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        // المتغيرات العامة تقرأ من الفاتورة $data
        const TAX_RATIO = {{ $data->tax->tax_ratio ?? 0 }};
        const TAX_TYPE = '{{ $data->tax_type ?? 'after' }}';
    </script>


    <script>
        function validateForm() {
            var inputs = document.querySelectorAll('[id^="qty_input_"], [id^="rate_input_"]');
            var isEmpty = false;

            inputs.forEach(function(input) {
                if (input.value.trim() === '') {
                    isEmpty = true;
                    return;
                }
            });

            if (isEmpty) {
                alert('يرجى ملئ جميع حقول الاسعار والكميات في الاصناف');
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }

        function show_form_product() {
            document.getElementById('form_product').classList.add('show');
            document.getElementById('form_product').style.display = 'block';
        }

        function close_form_product() {
            document.getElementById('form_product').classList.remove('show');
            document.getElementById('form_product').style.display = 'none';
        }

        function search_product_ajax(search_product, page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.sales_invoices.search_product_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'search_product': search_product,
                    'invoice_id': {{ $data->id }},
                    'page': page
                },
                success: function(data) {
                    console.log(data);
                    $('#search_product_table').html(data.view);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function invoices_table() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('invoices_table').innerHTML =
                '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '{{ route('accounting.sales_invoices.invoice_table') }}',
                method: 'post',
                headers: headers,
                data: {
                    'invoice_id': {{ $data->id }},
                },
                success: function(data) {
                    $('#invoices_table').html(data.view);
                    // استدعاء دالة حساب المجموع *بعد* تحميل الجدول
                    updateSubTotal();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function create_product_ajax(index) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.sales_invoices.create_product_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'item_id': document.getElementById('item_id_' + index).value,
                    'invoice_id': {{ $data->id }}
                },
                success: function(data) {
                    console.log(data.view);
                    invoices_table();
                    search_product_ajax(document.getElementById('search_product').value, page);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function delete_item(id) {
            var message_result = confirm('هل تريد حذف العنصر ؟');
            if (message_result) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '{{ route('accounting.sales_invoices.delete_item') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'id': id,
                    },
                    success: function(data) {
                        invoices_table();
                        toastr.success('تم حذف العنصر بنجاح')
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            }
        }

        // ===================================================
        // دالة updateTotal المصححة (تحل مشكلة اختفاء المجموع)
        // ===================================================
        function updateTotal(itemId) {
            var qty = parseFloat(document.getElementById('qty_input_' + itemId).value) || 0;
            var rate = parseFloat(document.getElementById('rate_input_' + itemId).value) || 0;
            var discount = parseFloat(document.getElementById('discount_input_' + itemId).value) || 0;

            var total = qty * rate;
            var discountAmount = 0;
            var originalPrice = total; // السعر الأصلي قبل الخصم

            if (discount > 0) {
                discountAmount = (total * (discount / 100)); // حساب مبلغ الخصم
                total = total - discountAmount; // خصم المبلغ من الإجمالي
            }

            var htmlContent;
            if (discount > 0) {
                // في حال وجود خصم
                htmlContent = `<div class="row">
                                <div class="col-md-6">
                                    <del>${originalPrice.toFixed(2)}</del>
                                </div>
                                <div>
                                    ${total.toFixed(2)}
                                </div>
                            </div>`;
            } else {
                // في حال عدم وجود خصم
                htmlContent = originalPrice.toFixed(2);
            }

            // عرض السعر
            document.getElementById('total_td_' + itemId).innerHTML = htmlContent;

            return {
                total: total, // المجموع بعد الخصم
                originalPrice: originalPrice, // المجموع قبل الخصم
                discountAmount: discountAmount // مبلغ الخصم
            };
        }

        // ===================================================
        // دالة updateSubTotal الصحيحة
        // ===================================================
        function updateSubTotal() {
            var totalNet = 0;
            var totalGross = 0;
            var totalDiscountAmount = 0;

            // ($invoice هي مصفوفة الأصناف التي تم تمريرها من الكنترولر الرئيسي)
            @foreach ($invoice as $key)
            var itemData = updateTotal({{ $key->id }});
            totalNet += itemData.total;
            totalGross += itemData.originalPrice;
            totalDiscountAmount += itemData.discountAmount;
            @endforeach

            var taxAmount = 0;
            var subTotalForDisplay = 0;
            var finalTotal = 0;

            // حساب الضريبة بناءً على نوعها (before/after)
            if (TAX_TYPE === 'before') {
                subTotalForDisplay = totalNet / (1 + (TAX_RATIO / 100));
                taxAmount = totalNet - subTotalForDisplay;
                finalTotal = totalNet;
            }
            else {
                subTotalForDisplay = totalNet;
                taxAmount = (totalNet * (TAX_RATIO / 100));
                finalTotal = totalNet + taxAmount;
            }

            // تحديث عناصر الـ DOM الموجودة في الملف الجزئي
            document.getElementById('sub_total').innerText = subTotalForDisplay.toFixed(2);
            document.getElementById('sub_discount').innerText = totalDiscountAmount.toFixed(2);
            document.getElementById('tax_id').innerText = taxAmount.toFixed(2);
            document.getElementById('sub_total_after_tax').innerText = finalTotal.toFixed(2);
        }

        // دالة تعديل المدخلات (صحيحة)
        function edit_inputs_from_invoice(id, value, operation) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = { "X-CSRF-Token": csrfToken };
            $.ajax({
                url: '{{ route('accounting.sales_invoices.edit_inputs_from_invoice') }}',
                method: 'post',
                headers: headers,
                data: { 'id': id, 'operation': operation, 'value': value },
                success: function(data) {
                    updateSubTotal(); // إعادة حساب كل شيء
                    toastr.success('تم التعديل بنجاح');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        // دوال الأجاكس لتحديث بيانات الفاتورة (صحيحة)
        function update_invoice_reference_number_ajax(value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = { "X-CSRF-Token": csrfToken };
            $.ajax({
                url: '{{ route('accounting.sales_invoices.update_invoice_reference_number_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': {{ $data->id }},
                    'invoice_reference_number': value
                },
                success: function(data) {
                    if (data.status == 'true') {
                        toastr.success(data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_purchase_invoices_from_ajax(operation, value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = { "X-CSRF-Token": csrfToken };
            $.ajax({
                url: '{{ route('accounting.sales_invoices.update_purchase_invoices_from_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': {{ $data->id }},
                    'operation': operation,
                    'value': value
                },
                success: function(data) {
                    console.log(data);
                    toastr.success(data.message)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_taxes_ajax(tax_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = { "X-CSRF-Token": csrfToken };
            $.ajax({
                url: '{{ route('accounting.sales_invoices.update_purchase_invoices_from_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'tax_id': tax_id,
                },
                success: function(data) {
                    console.log(data);
                    toastr.success(data.message)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        // دالة حفظ الضريبة (صحيحة ومعدلة لمنع الكاش)
        function update_tax_id_ratio() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = { "X-CSRF-Token": csrfToken };

            var tax_id = $('#tax_ratio').val();
            var tax_type = $('#tax_type').val();
            var invoice_id = {{ $data->id }}; // $data هو الفاتورة

            $.ajax({
                url: '{{ route('accounting.sales_invoices.update_tax_id_ratio') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': invoice_id,
                    'tax_id': tax_id,
                    'tax_type': tax_type
                },
                success: function(data) {
                    if(data.status == 'true') {
                        toastr.success(data.message);
                        location.reload(true); // إعادة تحميل الصفحة مع منع الكاش
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('خطأ في الاتصال');
                }
            });
        }

        var page = 1; // تعريف المتغير 'page' في النطاق العام

        $(document).ready(function() {
            document.getElementById('form_product').style.display = 'none';
            search_product_ajax(document.getElementById('search_product').value, page);
            invoices_table();
        });



        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            search_product_ajax(document.getElementById('search_product').value, page);
        });

        $(function() {
            $(document).on("keypress", function() {
                $("#search_product").focus();
            });
        });

        // ترحيل الفاتورة
        function post_invoice() {
            validate = validateForm();
            if (validate === true) {
                window.location.href =
                    '{{ route('accounting.sales_invoices.invoice_posting', ['id' => $data->id]) }}';
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#tax_id1').on('change', function() {
                var selectedValue = $(this).val();
                $('#tax_id2').empty();
                $('#tax_id2').append('<option value="">اختر قيمة الضريبة ...</option>');
                @foreach ($taxes as $key)
                if ('{{ $key->id }}' !== selectedValue) {
                    $('#tax_id2').append(
                        '<option value="{{ $key->id }}">{{ $key->tax_name }} ({{ $key->tax_ratio }}%)</option>'
                    );
                }
                @endforeach
            });
        });

        function alerttt() {

        }

        function if_checked() {
            var checkbox = document.getElementById("checkbox");
            var recurring_form = document.getElementById("recurring_form");

            if (checkbox.checked == true) {
                recurring_form.style.display = "block";
            } else {
                recurring_form.style.display = "none";
            }
        }

        function post_the_invoice() {
            window.location.href =
                '{{ route('accounting.sales_invoices.invoice_posting', ['id' => $data->id]) }}'
        }

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('image-zoom')) {
                const overlay = document.createElement('div');
                overlay.classList.add('image-preview-overlay');
                const img = document.createElement('img');
                img.src = e.target.src;
                overlay.appendChild(img);
                document.body.appendChild(overlay);
                setTimeout(() => overlay.classList.add('show'), 10);
                overlay.addEventListener('click', function (event) {
                    if (event.target === overlay) {
                        overlay.classList.remove('show');
                        setTimeout(() => overlay.remove(), 300);
                    }
                });
            }
        });
    </script>

    <script>
        $(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection
