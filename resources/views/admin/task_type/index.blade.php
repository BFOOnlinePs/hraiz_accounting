@extends('home')
@section('title')
    نوع المهمة
@endsection
@section('header_title')
    نوع المهمة
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    نوع المهمة
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')

    <div class="mb-2">
        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modal-lg">
            اضافة نوع مهمة
        </button>
    </div>

    <div class="card">

        <div class="card-header">
            <h3 class="text-center">انواع المهام</h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key)
                            <tr>
                                <td>{{ $key->type_name }}</td>
                                <td>
                                    <a class="btn btn-success btn-sm" href="{{ route('tasks_type.edit',['id'=>$key->id]) }}">تعديل</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection()

@section('script')

@endsection

