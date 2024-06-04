@extends('home')
@section('title')
    تعديل الرواتب
@endsection
@section('header_title')
    تعديل الرواتب
@endsection
@section('header_link')
    الرواتب
@endsection
@section('header_title_link')
    تعديل الرواتب
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">
        <div class="card-body">
            <div>
                <form action="{{ route('hr.salaries.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الموظفين</label>
                                <select class="form-control select2bs4" name="employee_id" id="">
                                    <option value="">اختر موظف ...</option>
                                    @foreach($users as $key)
                                        <option @if($key->id == $data->employee_id) selected @endif value="{{ $key->id }}">{{ $key->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">القيمة</label>
                                <input type="text" value="{{ $data->salary_value }}" name="salary_value" id="value_rewardEdit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">عدد الايام</label>
                                <input type="number" value="{{ $data->days }}" name="days" id="value_rewardEdit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">الشهر</label>
                                <input type="number" value="{{ $data->month }}" name="month" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">السنة</label>
                                <input type="number" value="{{ $data->year }}" name="year" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success" type="submit">تعديل</button>
                </form>
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
