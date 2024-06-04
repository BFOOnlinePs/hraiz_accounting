@extends('home')
@section('title')
    اعدادات الساعة
@endsection
@section('header_title')
    اعدادات الساعة
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    اعدادات الساعة
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#create-attendance-device">اضافة ساعة</button>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Ip</th>
                                    <th>Port</th>
                                    <th>User name</th>
                                    <th>Password</th>
                                    <th>Status right</th>
                                    <th>Status left</th>
                                    <th>Status up</th>
                                    <th>Status down</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($time_attendance_device->isEmpty())
                                    <tr>
                                        <td colspan="9" class="text-center">لا توجد بيانات</td>
                                    </tr>
                                @else
                                    @foreach($time_attendance_device as $key)
                                        <tr>
                                            <td>{{ $key->ip }}</td>
                                            <td>{{ $key->port }}</td>
                                            <td>{{ $key->user_name }}</td>
                                            <td>{{ $key->password }}</td>
                                            <td>{{ $key->status_right }}</td>
                                            <td>{{ $key->status_left }}</td>
                                            <td>{{ $key->status_up }}</td>
                                            <td>{{ $key->status_down }}</td>
                                            <td class="text-center text-success" id="check_connection_td_{{ $key->id }}">
                                                @if($key->status_device == 'success')
                                                    <span class="text-success fa fa-check-circle"></span>
                                                @else
                                                    <span class="text-danger fa fa-circle-stop"></span>
                                                @endif
                                                <span id="loader" style="font-size: 8px" class=""></span>
                                            </td>
                                            <td>
                                                <button onclick="get_time_attendance_data({{ $key }})" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></button>
                                                <button disabled onclick="async_data_from_attendance_device_ajax({{ $key->id }})" id="button_async_{{ $key->id }}" class="btn btn-dark btn-sm"><span class="fa fa-sync"></span></button>
                                                <a onclick="return confirm('هل انت متاكد من عملية الحذف ؟')" href="{{ route('setting.attendance_device.delete',['id'=>$key->id]) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
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
{{--test--}}
    @include('admin.setting.attendance_device.modals.time_attendance_devices')
    @include('admin.setting.attendance_device.modals.edit_time_attendance_devices')
    @include('admin.setting.attendance_device.modals.async_loader')
@endsection

@section('script')
    <script>
        function get_time_attendance_data(data) {
            $('#edit-attendance-device-modal').modal('show')
            $('#attendance_device_id').val(data.id);
            $('#ip_input').val(data.ip);
            $('#port_input').val(data.port);
            $('#user_name_input').val(data.user_name);
            $('#password_input').val(data.password);
            $('#status_up_input').val(data.status_up);
            $('#status_down_input').val(data.status_down);
            $('#status_right_input').val(data.status_right);
            $('#status_down_input').val(data.status_left);
        }
    </script>

    <script>
        $(document).ready(function () {
            @foreach($time_attendance_device as $key)
            check_connection_attendance_device_ajax({{ $key->id }},'{{ $key->ip }}',{{ $key->port }});
            @endforeach
        })

        function check_connection_attendance_device_ajax(index,ip,port){

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('check_connection_td_'+index).innerHTML = '<div style="font-size: 7px" class="col text-dark text-center"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '{{ route('setting.attendance_device.check_connection_attendance_device_ajax') }}',
                method: 'post',
                headers: headers,
                data:{
                    'ip':ip,
                    'port':port
                },
                success: function(data) {
                    if(data.success === 'true'){
                        $('#button_async_'+index).prop('disabled',false);
                        document.getElementById('check_connection_td_'+index).innerHTML = '<div data-toggle="tooltip" title="تم الاتصال بنجاح" style="font-size: 7px" class="col text-success text-center"><i class="fas fa-3x fa-check-circle" data-toggle="tooltip" title="تم الاتصال بنجاح"></i></div>';
                    }
                    else{
                        document.getElementById('check_connection_td_'+index).innerHTML = '<div style="font-size: 7px" class="col text-danger text-center"><i class="fas fa-3x fa-stop-circle"></i></div>';
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                }
            });
        }

        function async_data_from_attendance_device_ajax(id){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            var x = `
                    <h4>جاري الاقتران</h4>
                    <span><i class="fas fa-3x fa-sync-alt fa-spin"></i></span>`;
            $('#async-loader-modal').modal('show')
            $('#async_loader_col').html(x);
            $.ajax({
                url: '{{ route('setting.attendance_device.async_data_from_attendance_device_ajax') }}',
                method: 'post',
                headers: headers,
                data:{
                    'attendance_device_id':id,
                },
                success: function(data) {
                    if(data.success === 'true'){
                        var x = `
                            <h5>${data.message}</h5>
                            <span class="text-success"><i class="fa fa-3x fa-check-circle"></i></span>
                        `;
                        $('#async_loader_col').html(x);
                        setTimeout(function () {
                            $('#async-loader-modal').modal('hide');
                        },1000);
                    }
                    else{
                        var x = `
                            <h5>${data.message}</h5>
                            <span class="text-danger"><i class="fa fa-3x fa-stop-circle"></i></span>
                        `;
                        $('#async_loader_col').html(x);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                }
            });
        }

    </script>
@endsection
