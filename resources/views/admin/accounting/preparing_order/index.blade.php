@extends('home')
@section('title')
    التحضير
@endsection
@section('header_title')
    التحضير
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    التحضير
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
            <button class="btn btn-dark" onclick="return_modal('sales')">اضافة تحضير</button>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        <input onkeyup="returns_table(1)" type="text" id="reference_number" class="form-control" placeholder="بحث عن الرقم المرجعي">
                    </div>
                </div>
                <div class="col-md-2 d-flex justify-content-between">
                    <div class="form-group">
                        <input checked onchange="returns_table(1)" name="radio_invoice_type" class="radio_invoice_type" value="sales" id="sales_radio_button" type="radio">
                        <label for="sales_radio_button">مبيعات</label>
                    </div>
                    <div class="form-group">
                        <input onchange="returns_table(1)" name="radio_invoice_type" class="radio_invoice_type" value="purchase" id="purchase_radio_button" type="radio">
                        <label for="purchase_radio_button">مشتريات</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div id="returns_table">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
