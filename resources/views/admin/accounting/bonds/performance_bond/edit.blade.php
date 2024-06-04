@extends('home')
@section('title')
    تعديل سند صرف
@endsection
@section('header_title')
    تعديل سند صرف
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    تعديل سند صرف
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('accounting.bonds.performance_bond.update_performance_bond') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $data->id }}">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="gorm-group">
                                    <label for="">رقم الفاتورة</label>
                                    <input class="form-control" value="{{ $data->invoice_id }}" type="text" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="gorm-group">
                                    <label for="">القيمة</label>
                                    <input class="form-control" name="amount" title="يرجى ادخال ارقام فقط" value="{{ $data->amount }}" type="text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="gorm-group">
                                    <label for="">العملة</label>
                                    <select class="form-control" name="currency_id" id="">
                                        @foreach($currency as $key)
                                            <option @if($key->id == $data->currency_id) selected @endif value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="gorm-group">
                                    <label for="">الملاحظات</label>
                                    <textarea class="form-control" name="notes" id="" cols="30" rows="2">{{ $data->notes }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row mt-3">
                                    <div class="col-md-1">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" @if($data->payment_type == 'cash') checked @endif value="cash" id="cash" name="customRadio">
                                            <label for="cash" class="custom-control-label">كاش</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" @if($data->payment_type == 'check') checked @endif value="check" id="check" name="customRadio">
                                            <label for="check" class="custom-control-label">شيك</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3" style="display: none" id="check_information">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="checkNumber">رقم الشيك</label>
                                    <input name="check_number" value="{{ $data->check_number }}" type="text" class="form-control" id="checkNumber" placeholder="رقم الشيك" pattern="[0-9]+" title="يرجى إدخال رقم شيك صحيح (الأرقام فقط)">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">تاريخ الاستحقاق</label>
                                    <input name="due_date" value="{{ $data->due_date }}" id="due_date" type="date" class="form-control" placeholder="تاريخ الاستحقاق">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">اسم البنك</label>
                                    <input name="bank_name" value="{{ $data->bank_name }}" id="bank_name" type="text" class="form-control" placeholder="اسم البنك">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">تعديل البيانات</button>
                    </div>
                    <div class="col-md-4 text-center justify-content-center align-items-center d-flex">
                        <span style="font-size: 250px" class="fa fa-money-check-alt"></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('input[name="customRadio"]').on('change', function () {
                if ($(this).val() === 'check') {
                    $('#check_information').show();
                    $('#checkNumber').prop('required',true);
                    $('#due_date').prop('required',true);
                    $('#bank_name').prop('required',true);
                } else {
                    $('#check_information').hide();
                    $('#checkNumber').prop('required',false);
                    $('#due_date').prop('required',false);
                    $('#bank_name').prop('required',false);
                }
            });
            $('input[name="customRadio"]:checked').change();
        });

    </script>
@endsection

