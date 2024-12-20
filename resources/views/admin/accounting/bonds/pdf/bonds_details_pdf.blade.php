<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تفاصيل سند قبض</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            line-height: 1.6;
            direction: rtl;
            text-align: right;
        }
        h5 {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -10px;
            margin-left: -10px;
        }
        .col-md-12, .col-md-6, .col-md-3 {
            padding-right: 10px;
            padding-left: 10px;
        }
        .col-md-12 {
            width: 100%;
        }
        .col-md-6 {
            width: 50%;
        }
        .col-md-3 {
            width: 25%;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .text-center {
            text-align: center;
        }
        textarea {
            width: 100%;
            resize: none;
        }
        .btn {
            display: inline-block;
            padding: 5px 10px;
            font-size: 12px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #f0ad4e;
            border-radius: 4px;
        }
        .btn-warning {
            background-color: #f0ad4e;
        }
        .d-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        hr {
            border: 0;
            border-top: 1px solid #ddd;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <h5>
        @if ($data->invoice_type == 'payment_bond')
            تفاصيل سند قبض
        @else
            تفاصيل سند صرف
        @endif
    </h5>

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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">العملة</label>
                                        <input type="text" value="{{ $data->currency->currency_name}}">
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

</body>
</html>
