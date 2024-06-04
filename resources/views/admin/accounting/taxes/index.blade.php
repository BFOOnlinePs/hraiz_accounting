@extends('home')
@section('title')
    الضرائب
@endsection
@section('header_title')
الضرائب
@endsection
@section('header_link')
    الاعدادات
@endsection
@section('header_title_link')
الضرائب
@endsection
@section('script')

@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <button type="button" class="btn btn-dark mb-2" data-toggle="modal" data-target="#modal-lg">
        اضافة ضريبة
    </button>
    <div class="card">

        {{-- <div class="card-header">
            <h3 class="text-center">قائمة البنوك</h3>
        </div> --}}

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>اسم الضريبة</th>
                        <th>نسبة الضريبة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @if($data->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center">لا توجد بيانات</td>
                        </tr>
                    @else
                    @foreach ($data as $key)
                    <tr>
                        <td>{{ $key->tax_name }}</td>
                        <td>{{ $key->tax_ratio }}</td>
                        <td>
                            <a href="{{ route('accounting.texes.edit',['id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                            <a onclick="return confirm('هل تريد حذف البيانات ؟')" href="{{ route('accounting.texes.delete',['id'=>$key->id]) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                        </td>
                    </tr>
                @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    </div>
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('accounting.texes.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة ضريبة</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">اسم الضريبة</label>
                                    <input required type="text" class="form-control" name="tax_name" placeholder="اسم الضريبة">
                                </div>
                                <div class="form-group">
                                    <label for="">نسبة الضريبة</label>
                                    <input required type="text" class="form-control" name="tax_ratio" placeholder="اسم الضريبة">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>

                </div>
            </form>

        </div>
    </div>

@endsection()

@section('script')

@endsection

