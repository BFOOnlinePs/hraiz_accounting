@extends('home')
@section('title')
    فاتورة جديدة
@endsection
@section('header_title')
    فاتورة جديدة
@endsection
@section('header_link')
    فاتورة المبيعات
@endsection
@section('header_title_link')
    فاتورة جديدة
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')

    <div class="card card-success card-outline">
        <div class="card-body">
            <form action="{{ route('accounting.sales_invoices.create_new_invoices') }}" method="post">
                @csrf
                <div class="row text-center">
                    <div class="col-md-12">
                        <h1>فاتورة مبيعات جديدة</h1>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">العميل</label>
                                    <select required class="form-control select2bs4" name="client_id" id="">
                                        <option value="">اختر عميل</option>
                                        @foreach ($client as $key)
                                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="">الرقم المرجعي للفاتورة</label>
                                    <input required value="INV-S-{{ session()->get('login_date') }}-{{ $get_invoice_order_number }}" name="invoice_reference_number" placeholder="ادخل الرقم المرجعي" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <?php
                                    $month = date('m');
                                    $day = date('d');
                                    $year = date('Y');
                                    $today = $year . '-' . $month . '-' . $day;
                                    ?>
                                    <label for="">تاريخ الفاتورة</label>
                                    <input required type="date" name="bill_date" class="form-control text-center"
                                           value="{{ $today }}">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="">الضريبة</label>
                                    <select name="tax_id" id="tax_id" class="form-control select2bs4">
                                        <option value="">اختر قيمة الضريبة ...</option>
                                        @foreach ($taxes as $key)
                                            <option value="{{ $key->id }}">{{ $key->tax_name }} ({{ $key->tax_ratio }}%)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">العملة</label>
                                    <select required name="currency_id" id="currency_id" class="form-control select2bs4">
                                        <option value="">اختر العملة ...</option>
                                        @foreach ($currency as $key)
                                            <option value="{{ $key->id }}">{{ $key->currency_name }} {{ $key->currency_symbol }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">ملاحظات</label>
                                    <textarea style="background-color: #ffbc0773" class="form-control" placeholder="يرجى ادخال الملاحظات" name="note" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div style="display: none" id="recurring_form" class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">التكرار خلال</label>
                                            <input type="text" name="repeat_every" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">خلال</label>
                                            <select class="form-control" name="repeat_type" id="">
                                                <option value="days">يوم</option>
                                                <option value="weeks">اسبوع</option>
                                                <option value="months">شهر</option>
                                                <option value="years">سنة</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">الدورة</label>
                                            <input type="text" name="no_of_cycles" class="form-control" placeholder="الدورة">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-dark">انشاء فاتورة مبيعات</button>
            </form>
        </div>
    </div>

    @endsection()

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        // {{--$(document).ready(function () {--}}
        // {{--$('#tax_id').on('change', function () {--}}
        // {{--    var selectedValue = $(this).val();--}}

        // {{--    // Clear the options in tax_id2--}}
        // {{--    $('#tax_id2').empty();--}}

        // {{--    // Add default option to tax_id2--}}
        // {{--    $('#tax_id2').append('<option value="">اختر قيمة الضريبة ...</option>');--}}

        // {{--    // Add formatted options to tax_id2 based on the selected value in tax_id--}}
        // {{--    @foreach ($taxes as $key)--}}
        // {{--        if ('{{ $key->id }}' !== selectedValue) {--}}
        // {{--            $('#tax_id2').append('<option value="{{ $key->id }}">{{ $key->tax_name }} ({{ $key->tax_ratio }}%)</option>');--}}
        // {{--        }--}}
        // {{--    @endforeach--}}
        // {{--});--}}
        // {{--});--}}


        function if_checked() {
            var checkbox = document.getElementById("checkbox");
            var recurring_form = document.getElementById("recurring_form");

            if (checkbox.checked == true) {
                recurring_form.style.display = "block";
            } else {
                recurring_form.style.display = "none";
            }
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
