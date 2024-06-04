@extends('home')
@section('title')
    الآلات
@endsection
@section('header_title')
    الآلات
@endsection
@section('header_link')
    الاعدادات
@endsection
@section('header_title_link')
    الآلات
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('setting.machine.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $data->id }}" name="id">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">اسم الآلة</label>
                            <input type="text" value="{{ $data->machines_name }}" class="form-control" name="machines_name">
                        </div>
                        <div class="form-group">
                            <label for="">اسم الآلة</label>
                            <input type="text" value="{{ $data->machines_description }}" class="form-control" name="machines_description">
                        </div>
                        @if(!empty($data->machines_image))
                            <div class="col-md-12">
                                <img style="width: 180px" src="{{ asset('storage/machine/'.$data->machines_image) }}" alt="">
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="">رفع صورة</label>
                            <input type="file" class="form-control" name="machines_image">
                        </div>
                        <button class="btn btn-success">تعديل</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
