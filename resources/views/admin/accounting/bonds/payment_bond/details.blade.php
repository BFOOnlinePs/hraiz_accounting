@extends('home')
@section('title')
    @if ($data->invoice_type == 'performance_bond')
        تفاصيل سند صرف
    @else
        تفاصيل سند قبض
    @endif
@endsection
@section('header_title')
    @if ($data->invoice_type == 'performance_bond')
        تفاصيل سند صرف
    @else
        تفاصيل سند قبض
    @endif
@endsection
@section('header_link')
    @if ($data->invoice_type == 'performance_bond')
        تفاصيل سند صرف
    @else
        تفاصيل سند قبض
    @endif
@endsection
@section('header_title_link')
    @if ($data->invoice_type == 'performance_bond')
        تفاصيل سند صرف
    @else
        تفاصيل سند قبض
    @endif
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
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="invoice_modal_type" value="invoice">
                            <div class="row">
                                <div class="col-md-12 d-flex">
                                    <span style="flex: 1;font-size:18px" class="">
                                        @if ($data->invoice_type == 'performance_bond')
                                        تفاصيل سند صرف
                                        @else
                                        تفاصيل سند قبض
                                        @endif
                                    </span>
                                    <a target="_blank" href="{{ route('accounting.bonds.check.bonds_pdf',['id'=>$data->id]) }}" class="btn btn-sm btn-warning">
                                        <span class="fa fa-print"></span>
                                    </a>
                                </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">اسم العميل</label>
                                        <input readonly type="text" value="{{ $data->client->name ?? '' }}"
                                            class="form-control" name="bond_number" id="bond_number"
                                            placeholder="رقم السند">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">فاتورة رقم</label>
                                        <input readonly readonly type="text"
                                            value="@if ($data->invoice_id == -1) غير مرتبطة بفاتورة @else {{ $data->invoice_id ?? 'asdads' }} @endif"
                                            class="form-control" name="invoice_id" id="invoice_select">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">الرقم المرجعي</label>
                                        <input readonly type="text" value="{{ $data->reference_number }}"
                                            name="reference_number" class="form-control" placeholder="الرقم المرجعي">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">العملة</label>
                                        <select disabled class="form-control select2bs4" required name="currency_id"
                                            id="">
                                            <option value="">اختر العملة ...</option>
                                            @foreach ($currencies as $key)
                                                <option @if ($key->id == $data->currency_id) selected @endif
                                                    value="{{ $key->id }}">{{ $key->currency_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">القيمة</label>
                                        <input readonly required id="invoice_amount" type="text"
                                            value="{{ $data->amount }}" name="amount" class="form-control text-center"
                                            style="background-color: palegoldenrod;font-size: 50px;height: 80px !important;vertical-align: middle;padding-top: 25px"
                                            pattern="[0-9]+" title="يجب ادخال ارقام فقط" placeholder="قيمة سند القبض">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">الملاحظات</label>
                                        <textarea readonly class="form-control" name="notes" id="" cols="30" rows="3">{{ $data->notes }}</textarea>
                                    </div>
                                </div>
                                {{-- <div class="col-md-1">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" value="cash" id="cash"
                                            name="customRadio" checked="">
                                        <label for="cash" class="custom-control-label">كاش</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" value="check" id="check"
                                            name="customRadio">
                                        <label for="check" class="custom-control-label">شيك</label>
                                    </div>
                                </div> --}}
                            </div>
                            @if ($data->payment_type == 'check')
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="checkNumber">رقم الشيك</label>
                                            <input name="check_number" value="{{ $data->check_number }}" type="text"
                                                class="form-control" id="checkNumber" placeholder="رقم الشيك"
                                                pattern="[0-9]+" title="يرجى إدخال رقم شيك صحيح (الأرقام فقط)">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">تاريخ الاستحقاق</label>
                                            <input name="due_date" id="due_date" value="{{ $data->due_date }}"
                                                type="date" class="form-control" placeholder="تاريخ الاستحقاق">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">اسم البنك</label>
                                            <input name="bank_name" value="{{ $data->bank_name }}" id="bank_name"
                                                type="text" class="form-control" placeholder="اسم البنك">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">حالة الشيك</label>
                                            <select class="form-control" disabled name="check_status" id="check_status">
                                                <option @if ($data->check_status == 'paid') selected @endif value="paid">
                                                    مصروف</option>
                                                <option @if ($data->check_status == 'under_collection') selected @endif
                                                    value="under_collection">
                                                    في التحصيل</option>
                                                <option @if ($data->check_status == 'returned') selected @endif value="returned">
                                                    راجع</option>
                                                <option @if ($data->check_status == 'portfolio') selected @endif value="portfolio">
                                                    في المحفظة</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-dark">اضافة البيانات</button>
                                    </div> --}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $('input[name="customRadio"]').on('change', function() {
            if ($(this).val() === 'check') {
                $('#check_information_client').css('display', 'block');
                $('#check_information').css('display', 'block');
                $('#checkNumber').prop('required', true);
                $('#due_date').prop('required', true);
                $('#bank_name').prop('required', true);
            } else {
                $('#check_information_client').hide();
                $('#check_information').hide();
            }
        })
    </script>
@endsection
