@extends('home')
@section('title')
    المصروفات
@endsection
@section('header_title')
    المصروفات
@endsection
@section('header_link')
    الاعدادات
@endsection
@section('header_title_link')
    المصروفات
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card mt-2">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modal-lg">
                        اضافة مصروف
                    </button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <table class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($data->isEmpty())
                                <tr>
                                    <td colspan="2" class="text-center">لا توجد بيانات</td>
                                </tr>
                            @else
                                @foreach($data as $key)
                                    <tr>
                                        <td>{{ $key->title }}</td>
                                        <td>
                                            <a href="" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('setting.expenses_category.create') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة مصروف</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">الاسم</label>
                                    <input type="text" name="title" class="form-control" placeholder="اكتب الاسم هنا">
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
@endsection
