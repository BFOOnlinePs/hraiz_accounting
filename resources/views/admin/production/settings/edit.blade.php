@extends('home')
@section('title')
    اوامر الانتاج
@endsection
@section('header_title')
    اوامر الانتاج
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    اوامر الانتاج
    @endsection
    @section('style')
    @endsection
    @section('content')
        @include('admin.messge_alert.success')
        @include('admin.messge_alert.fail')
        <div class="card">
            <div class="card-body">
                <form action="{{ route('production.production_inputs.settings.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">اسم الاعداد</label>
                                        <input type="text" class="form-control" name="production_name" value="{{ $data->production_name }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">القيمة</label>
                                        <input type="text" class="form-control" name="production_value" value="{{ $data->production_value }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">ملاحظات</label>
                                        <textarea class="form-control" name="production_description" id="" cols="30" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="form-group">
                                <label for="">الصورة</label>
                                <br>
                                <img width="120px" src="{{ asset('storage/production/'.$data->product_image) }}" alt="">
                            </div>
                            <input type="file" class="form-control" name="product_image">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">حفظ التعديلات</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection

