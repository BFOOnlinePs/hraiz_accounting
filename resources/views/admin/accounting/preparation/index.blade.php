@extends('home')
@section('title')
    التحضير
@endsection
@section('header_title')
    التحضير
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    التحضير
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <h4>طلبيات بانتظار التحضير</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">من تاريخ</label>
                                <input type="date" onchange="preparation_list_ajax()" id="from_date"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">الى تاريخ</label>
                                <input type="date" onchange="preparation_list_ajax()" id="to_date"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">الموظف</label>
                                <select onchange="preparation_list_ajax()" class="select2bs4 form-control" name=""
                                    id="employee_id">
                                    <option value="">جميع الموظفين</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">حالة طلبية التحضير</label>
                                <select onchange="preparation_list_ajax()" class="form-control" name=""
                                    id="status">
                                    <option value="">جميع الحالات</option>
                                    <option value="waiting_prepared">قيد التحضير</option>
                                    <option value="ready_prepared">تم التحضير</option>
                                    <option value="delivered">تم التسليم</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class='table-responsive' id="preparation_list_table">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            preparation_list_ajax();
        })

        function preparation_list_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.preparation.list_preparation_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'from_date': $('#from_date').val(),
                    'to_date': $('#to_date').val(),
                    'to_user': $('#employee_id').val(),
                    'status': $('#status').val()
                },
                success: function(data) {
                    $('#preparation_list_table').html(data.view);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_status_preparation(id, value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.preparation.update_status_preparation') }}',
                method: 'post',
                headers: headers,
                data: {
                    id: id,
                    status: value
                },
                success: function(data) {

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
    </script>

    <script>
        $(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection
