@extends('home')
@section('title')
    تعديل عرض سعر بيع
@endsection
@section('header_title')
    تعديل عرض سعر بيع
@endsection
@section('header_link')
    عروض اسعار البيع
@endsection
@section('header_title_link')
    تعديل عرض سعر بيع
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
            <form action="{{ route('price_offer_sales.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $data->id }}">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">اسم الزبون</label>
                            <select class="form-control select2bs4" name="customer_id" id="">
                                @foreach($clients as $key)
                                    <option @if($key->id == $data->customer_id) selected @endif value="{{ $key->id }}">{{ $key->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">العملة</label>
                            <select class="form-control select2bs4" name="currency_id" id="">
                                @foreach($currency as $key)
                                    <option @if($key->currency_id == $data->currency_id) selected @endif value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">الملاحظات</label>
                            <textarea class="form-control" name="notes" id="" cols="30" rows="3">{{ $data->notes }}</textarea>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success">حفظ التعديلات</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection

