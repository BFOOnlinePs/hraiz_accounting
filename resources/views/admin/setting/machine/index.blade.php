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
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modal-lg">
        اضافة آلة
    </button>
    <div class="card mt-2">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>الوصف</th>
                                    <th>الصورة</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!$data->isEmpty())
                                @foreach($data as $key)
                                    <tr>
                                        <td>{{ $key->machines_name }}</td>
                                        <td>{{ $key->machines_description }}</td>
                                        <td>
                                            <img style="width: 100px" src="{{ asset('storage/machine/'.$key->machines_image) }}" alt="">
                                        </td>
                                        <td>
                                            <a href="{{ route('setting.machine.edit',['id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                            <a onclick="return confirm('هل انت متاكد من عملية الحذف ؟')" href="{{ route('setting.machine.delete',['id'=>$key->id]) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">لا توجد بيانات</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('setting.machine.create') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                    <h4 class="modal-title">اضافة الة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اسم الآلة</label>
                                <input class="form-control" name="machines_name" type="text" placeholder="اسم الآلة">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">وصف الآلة</label>
                                <input class="form-control" name="machines_description" type="text" placeholder="اسم الآلة">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الصورة</label>
                                <input type="file" class="form-control" name="machines_image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection()
