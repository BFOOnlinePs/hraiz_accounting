@extends('home')
@section('title')
    الاصناف
@endsection
@section('header_title')
    الاصناف
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    الاصناف
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <form action="{{ route('product.update_product_compatibility') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $data->id }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اسم الصنف</label>
                                <select class="form-control select2bs4" name="product_id" id="">
                                    @foreach($products as $key)
                                        <option @if($key->id == $data->product->id) selected @endif value="{{ $key->id }}">{{ $key->product_name_ar }}</option>
                                    @endforeach
                                </select>
{{--                                <input type="text" class="form-control" value="{{ $data->product->product_name_ar }}">--}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اسم الصنف المتوافق</label>
                                <select class="form-control select2bs4" name="product_compatibility_id" id="">
                                    @foreach($products as $key)
                                        <option @if($key->id == $data->product_compatibility->id) selected @endif value="{{ $key->id }}">{{ $key->product_name_ar }}</option>
                                    @endforeach
                                </select>
{{--                                <input type="text" class="form-control" value="{{ $data->product_compatibility->product_name_ar }}">--}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">ارفاق صورة</label>
                                <input type="file" class="form-control" name="product_image">
                            </div>
                        </div>
                        @if(!empty($data->product_image))
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">صورة المنتج</label>
                                    <br>
                                    <img width="150px" src="{{ asset('storage/product/'.$data->product_image) }}" alt="">
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">ملاحظات</label>
                                <textarea name="notes" class="form-control" id="" cols="30" rows="3">{{ $data->notes }}</textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">تعديل البيانات</button>
                </form>
            </div>
        </div>
        <div class="loader-container" id="loaderContainer" style="display: none;">
            <div class="loader"></div>
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

