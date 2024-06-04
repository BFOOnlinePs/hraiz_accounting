@extends('home')
@section('title')
    المخازن
@endsection
@section('header_title')
    المخازن
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    المخازن
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
@section('content')

    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                {{--                <div class="card-header">--}}
                {{--                    <h3 class="text-center">قائمة الأصناف</h3>--}}
                {{--                </div>--}}

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-dark" data-toggle="modal" data-target="#wherehouseCreateModal">اضافة مخزن</button>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th>اسم المخزن</th>
                                                <th>العنوان</th>
                                                <th>رقم الهاتف</th>
                                                <th>نوع المخزن</th>
                                                <th>المسؤول عن المخزن</th>
                                                <th>العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if($data->isEmpty())
                                            <tr>
                                                <td colspan="6" class="text-center">لا يوجد بيانات</td>
                                            </tr>
                                        @else
                                            @foreach($data as $key)
                                                <tr>
                                                    <td>{{ $key->wherehouse_name }}</td>
                                                    <td>{{ $key->wherehouse_address }}</td>
                                                    <td>{{ $key->wherehouse_phone }}</td>
                                                    <td>{{ $key->wherehouse_type }}</td>
                                                    <td>{{ $key->user->name }}</td>
                                                    <td>
                                                        <button onclick="wherehouse_edit_modal_open({{ $key }})" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></button>
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
            </div>
        </div>
    </div>
    @include('admin.wherehouse.modals.wherehouseCreateModal')
    @include('admin.wherehouse.modals.wherehouseEditModal')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        function wherehouse_edit_modal_open(data) {
            $('#wherehouse_id').val(data.id);
            $('#wherehouse_name').val(data.wherehouse_name);
            $('#wherehouse_phone').val(data.wherehouse_phone);
            $('#wherehouse_address').val(data.wherehouse_address);
            $('#wherehouse_type').val(data.wherehouse_type);
            var newValue = data.wherehouse_store_manager;
            $('#wherehouse_store_manager').val(data.wherehouse_store_manager).trigger('change');
            $('#wherehouseEditModal').modal('show');
        }
    </script>
    <script>
        $(function (){
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection
