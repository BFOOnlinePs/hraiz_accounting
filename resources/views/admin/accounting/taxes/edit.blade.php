@extends('home')
@section('title')
    تعديل الضريبة
@endsection
@section('header_title')
    تعديل الضريبة
@endsection
@section('header_link')
    الضرائب
@endsection
@section('header_title_link')
    تعديل الضريبة
@endsection
@section('script')
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('accounting.texes.update') }}" method="post">
                @csrf
                <input type="hidden" value="{{ $data->id }}" name="id">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">اسم الضريبة</label>
                            <input type="text" value="{{ $data->tax_name }}" class="form-control" name="tax_name">
                        </div>
                        <div class="form-group">
                            <label for="">نسبة الضريبة</label>
                            <input type="number" value="{{ $data->tax_ratio }}" class="form-control" name="tax_ratio">
                        </div>
                    </div>
                </div>
                <button class="btn btn-success">تعديل</button>
            </form>
        </div>
    </div>
@endsection()

@section('script')
@endsection
