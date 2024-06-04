@extends('home')
@section('title')
    أنواع الإجازات
@endsection
@section('header_title')
    أنواع الإجازات
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
أنواع الإجازات

@endsection
@section('style')
<link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-default">إضافة نوع إجازة</button>
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">أنواع الإجازات</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">#
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">نوع الإجازة</th>
                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($vacations_types->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center" style="background-color: rgba(128, 128, 128, 0.274)">لا توجد نتائج</td>
                        </tr>
                    @endif
                    @foreach ($vacations_types as $key)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $key->type_name }}</td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="edit_vacations_types({{$key->id}} , '{{$key->type_name}}')"><span class="fa fa-edit pt-1"></span></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @include('admin.setting.vacations_types.modals.addVacationsTypesModal')
            @include('admin.setting.vacations_types.modals.editVacationsTypesModal')
        </div>

    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        function edit_vacations_types(id , type_name)
        {
            document.getElementById('id_editVacationsTypesModal').value = id;
            document.getElementById('type_name_editVacationsTypesModal').value = type_name;
            $('#editVacationsTypesModal').modal('show');
        }
    </script>

@endsection

