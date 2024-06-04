@extends('home')
@section('title')
    الموظفين
@endsection
@section('header_title')
    الموظفين
@endsection
@section('header_link')
@endsection
@section('header_title_link')
    الموظفين
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">قائمة الموظفين</h3>
                </div>
                <div class="card-body">
                    <div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <input type="text" onkeyup="employee_table()" class="form-control" id="search" placeholder="بحث">
                                    </div>
                                </div>
                                <div id="employee_table">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-2">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('users.employees.add') }}" class="btn form-control btn-dark mb-2">إضافة موظف</a>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="form-group">
                        <a href="{{ route('users.procurement_officer.index') }}" class="btn btn-sm btn-warning form-control">موظف المشتريات</a>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('users.storekeeper.index') }}" class="btn btn-sm btn-warning form-control">أمين المستودع</a>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('users.secretarial.index') }}" class="btn btn-sm btn-warning form-control">سكرتيريا</a>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('users.supplier.index') }}" class="btn btn-sm btn-warning form-control">الموردين</a>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('users.delivery_company.index') }}" class="btn btn-sm btn-warning form-control">شركات الشحن</a>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('users.clearance_companies.index') }}" class="btn btn-sm btn-warning form-control">شركات التخليص</a>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('users.local_carriers.index') }}" class="btn btn-sm btn-warning form-control">شركات النقل المحلي</a>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('users.insurance_companies.index') }}" class="btn btn-sm btn-warning form-control">شركات التأمين</a>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('users.clients.index') }}" class="btn btn-sm btn-warning form-control">زبائن</a>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('users.employees.index') }}" class="btn btn-sm btn-warning form-control">موظفين</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            employee_table();
        });
        function updateStatus(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: "{{ url('users/updateStatus') }}",
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'user_status': document.getElementById('customSwitch' + id).checked
                },
                success: function(data) {
                    toastr.success('تم تعديل الحالة بنجاح');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                }
            });
        }
        function employee_table() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: "{{ route('users.employees.employee_table') }}",
                method: 'post',
                headers: headers,
                data: {
                    'search': document.getElementById('search').value
                },
                success: function(data) {
                    $('#employee_table').html(data.view);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    </script>
@endsection
