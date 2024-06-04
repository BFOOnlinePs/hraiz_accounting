@extends('home')
@section('title')
    اعدادات النظام
@endsection
@section('header_title')
    اعدادات النظام
@endsection
@section('header_link')
    الاعدادات
@endsection
@section('header_title_link')
    اعدادات النظام
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">اعدادات النظام</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('setting.system_setting.create') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ !empty($data->id)??$data->id }}" name="id">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">اسم الشركة</label>
                                        <input type="text" value="{{ $data->company_name ?? '' }}" class="form-control" name="company_name" placeholder="اسم الشركة">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">عنوان الشركة</label>
                                        <input type="text" value="{{ $data->company_address ?? '' }}" class="form-control" name="company_address" placeholder="عنوان الشركة">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">رقم الهاتف</label>
                                        <input type="text" value="{{ $data->company_phone ?? '' }}" class="form-control" name="company_phone" placeholder="رقم الهاتف">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">اسم الشركة انجليزي</label>
                                        <input type="text" value="{{ $data->company_name_en ?? '' }}" class="form-control" name="company_name_en" placeholder="اسم الشركة">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">عنوان الشركة انجليزي</label>
                                        <input type="text" value="{{ $data->company_address_en ?? '' }}" class="form-control" name="company_address_en" placeholder="عنوان الشركة">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">اسم الشركة عبري</label>
                                        <input type="text" value="{{ $data->company_name_he ?? '' }}" class="form-control" name="company_name_he" placeholder="اسم الشركة">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">عنوان الشركة عبري</label>
                                        <input type="text" value="{{ $data->company_address_he ?? '' }}" class="form-control" name="company_address_he" placeholder="عنوان الشركة">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">لون الصفحة الجانبية</label>
                                        <input value="{{ ($data->sidebar_color)??'#000000' }}" name="sidebar_color" class="form-control" type="color">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row text-center">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">لوجو الشركة</label>
                                        <br>
                                        @if(!empty($data->company_logo))
                                            <img style="width: 100px" src="{{ asset('storage/setting/'.$data->company_logo) }}" alt="">
                                            <br>
                                        @endif
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="company_logo" class="custom-file-input"
                                                       id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">اختر ملف</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">رفع الصورة</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">صورة الترويسة</label>
                                        <br>
                                        @if(!empty($data->letter_head_image))
                                            <img style="width: 100px" src="{{ asset('storage/setting/'.$data->letter_head_image) }}" alt="">
                                            <br>
                                        @endif
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="letter_head_image" class="custom-file-input"
                                                       id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">اختر ملف</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">رفع الصورة</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-app bg-success">
                        <i class="fas fa-save"></i> حفظ
                    </button>
                </form>
            </div>
        </div>
{{--    <div class="card">--}}
{{--        <div class="card-header">--}}
{{--            <h5 class="text-center">اعدادات ساعة الدوام</h5>--}}
{{--        </div>--}}
{{--        <div class="card-body">--}}
{{--            <div class="row mb-2">--}}
{{--                <button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#create-attendance-device">اضافة ساعة</button>--}}
{{--            </div>--}}
{{--            <div class="row">--}}
{{--                <div class="table-responsive">--}}
{{--                    <table class="table table-sm table-bordered table-hover">--}}
{{--                        <thead>--}}
{{--                            <tr>--}}
{{--                                <th>Ip</th>--}}
{{--                                <th>Port</th>--}}
{{--                                <th>User name</th>--}}
{{--                                <th>Password</th>--}}
{{--                                <th>Status right</th>--}}
{{--                                <th>Status left</th>--}}
{{--                                <th>Status up</th>--}}
{{--                                <th>Status down</th>--}}
{{--                                <th>Status</th>--}}
{{--                                <th></th>--}}
{{--                            </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @if($time_attendance_device->isEmpty())--}}
{{--                            <tr>--}}
{{--                                <td colspan="9" class="text-center">لا توجد بيانات</td>--}}
{{--                            </tr>--}}
{{--                        @else--}}
{{--                            @foreach($time_attendance_device as $key)--}}
{{--                                <tr>--}}
{{--                                    <td>{{ $key->ip }}</td>--}}
{{--                                    <td>{{ $key->port }}</td>--}}
{{--                                    <td>{{ $key->user_name }}</td>--}}
{{--                                    <td>{{ $key->password }}</td>--}}
{{--                                    <td>{{ $key->status_right }}</td>--}}
{{--                                    <td>{{ $key->status_left }}</td>--}}
{{--                                    <td>{{ $key->status_up }}</td>--}}
{{--                                    <td>{{ $key->status_down }}</td>--}}
{{--                                    <td class="text-center text-success" id="check_connection_td_{{ $key->id }}">--}}
{{--                                        @if($key->status_device == 'success')--}}
{{--                                            <span class="text-success fa fa-check-circle"></span>--}}
{{--                                        @else--}}
{{--                                            <span class="text-danger fa fa-circle-stop"></span>--}}
{{--                                        @endif--}}
{{--                                            <span id="loader" style="font-size: 8px" class=""></span>--}}

{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <button onclick="get_time_attendance_data({{ $key }})" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></button>--}}
{{--                                        <button disabled onclick="async_data_from_attendance_device_ajax({{ $key->id }})" id="button_async_{{ $key->id }}" class="btn btn-dark btn-sm"><span class="fa fa-sync"></span></button>--}}
{{--                                        <a href="" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    @include('admin.setting.system_setting.modals.time_attendance_devices')--}}
{{--    @include('admin.setting.system_setting.modals.edit_time_attendance_devices')--}}
{{--    @include('admin.etting.system_setting.modals.async_loader')--}}
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@endsection
