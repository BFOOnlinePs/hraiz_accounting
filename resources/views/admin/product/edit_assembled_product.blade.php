@extends('home')
@section('title')
    المنتجات المتوافقة
@endsection
@section('header_title')
    المنتجات المتوافقة
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    المنتجات المتوافقة
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <form action="{{ route('product.update_assembled_product') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اسم المنتج المتوافق</label>
                                <select class="form-control select2bs4" name="assembled_product" id="">
                                    @foreach($products as $key)
                                        <option @if($key->id == $data->assembled_product->id) selected @endif value="{{ $key->id }}">{{ $key->product_name_ar }}</option>
                                    @endforeach
                                </select>
                                {{--                                <input type="text" class="form-control" value="{{ $data->product->product_name_ar }}">--}}
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

