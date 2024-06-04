@extends('home')
@section('title')
    الموظفين
@endsection
@section('header_title')
    الرواتب
@endsection
@section('header_link')
@endsection
@section('header_title_link')
    الرواتب
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <button onclick="showCreateSalaryModal()" class="btn btn-dark mb-2">إضافة راتب</button>
    <div class="card">
        <div class="card-header">
            <h3 class="text-center">قائمة الرواتب</h3>
        </div>
        <div class="card-body">
            <div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <!-- <input type="text" onkeyup="employee_table()" class="form-control" id="search" placeholder="بحث"> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>اسم الموظف</th>
                                    <th>القيمة</th>
                                    <th>الشهر</th>
                                    <th>السنة</th>
                                    <th>عدد الايام</th>
                                    <th>تاريخ الاضافة</th>
                                    <th>الحالة</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($data->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">لا توجد بيانات</td>
                                </tr>
                            @else
                                @foreach($data as $key)
                                    <tr>
                                        <td>{{ $key->employee->name }}</td>
                                        <td>{{ $key->salary_value }}</td>
                                        <td>{{ $key->month }}</td>
                                        <td>{{ $key->year }}</td>
                                        <td>{{ $key->days }}</td>
                                        <td>{{ $key->insert_at }}</td>
                                        <td>{{ $key->status }}</td>
                                        <td>
                                            <a href="{{ route('hr.salaries.edit',['id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
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
    </div>
    @include('admin.hr.salaries.modals.salaryCreate')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        function showCreateSalaryModal()
        {
            $('#create_salary_modal').modal('show');
        }
    </script>

    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endsection
