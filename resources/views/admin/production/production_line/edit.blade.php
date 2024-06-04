@extends('home')
@section('title')
    خطوط الانتاج
@endsection
@section('header_title')
    خطوط الانتاج
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    خطوط الانتاج
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
            <form action="{{ route('production.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $data->id }}">
                <div class="row">
                    <div class="col-md-8">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اسم خط الانتاج</label>
                                <input class="form-control" name="production_name" type="text" value="{{ $data->production_name }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">المنتج</label>
                                <select class="form-control select2bs4" name="product_id" id="">
                                    <option value="">اختر منتج ...</option>
                                    @foreach($products as $key)
                                        <option @if($data->product_id == $key->id) selected @endif value="{{ $key->id }}">{{ $key->product_name_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الملاحظات</label>
                                <textarea name="production_notes" class="form-control" id="" cols="30" rows="3">{{ $data->production_notes }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        @if(!empty($data->production_image))
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">صورة المنتج</label>
                                    <br>
                                    <img src="{{ asset('storage/production/'.$data->production_image) }}" alt="">
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اضافة صورة</label>
                                <input type="file" name="production_image" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success">تعديل</button>
            </form>
        </div>
    </div>

@endsection()

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

