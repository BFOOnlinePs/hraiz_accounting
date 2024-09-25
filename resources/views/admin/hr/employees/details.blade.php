@extends('home')
@section('title')
    تفاصيل الموظف
@endsection
@section('header_title')
    تفاصيل الموظف
@endsection
@section('header_link')
    الموظفين
@endsection
@section('header_title_link')
    تفاصيل الموظف
@endsection
@section('style')
    <style>
        .active {
            color: black !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" id="employee_id" value="{{$data->id}}">
                    <h3 class="pb-3">{{ $data->name }}</h3>
                    <ul class="nav nav-tabs alert-info text-white" style="" id="custom-content-below-tab"
                        role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if(session('tab_id') == null) active @endif @if(session('tab_id') == 1) active @endif text-white"
                               id="custom-content-below-home-tab"
                               data-toggle="pill"
                               href="#custom-content-below-home" role="tab"
                               aria-controls="custom-content-below-home"
                               aria-selected="@if(\Illuminate\Support\Facades\Session::has('tab_id')) @if(session('tab_id') == 1) true @else false @endif @endif">معلومات
                                الموظف</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white @if(session('tab_id') == 2) active @endif"
                               id="custom-content-below-attendance-tab" data-toggle="pill"
                               href="#custom-content-below-attendance" role="tab"
                               aria-controls="custom-content-below-attendance" aria-selected="false">سجل الحضور
                                والمغادرة</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(session('tab_id') == 3) active @endif text-white"
                               id="salaries-tab" data-toggle="pill"
                               href="#salaries" role="tab"
                               aria-controls="salaries"
                               aria-selected="@if(\Illuminate\Support\Facades\Session::has('tab_id')) @if(session('tab_id') == 2) true @else false @endif @endif">الرواتب</a>
                        </li>
                        {{--                            <li class="nav-item">--}}
                        {{--                                <a class="nav-link text-white @if(session('tab_id') == 4) active @endif"--}}
                        {{--                                    id="custom-content-below-orders-tab" data-toggle="pill"--}}
                        {{--                                    href="#custom-content-below-orders" role="tab"--}}
                        {{--                                    aria-controls="custom-content-below-orders" aria-selected="false">المهام</a>--}}
                        {{--                            </li>--}}
                        <li class="nav-item">
                            <a class="nav-link text-white @if(session('tab_id') == 5) active @endif"
                               id="custom-content-below-rewards-tab" data-toggle="pill"
                               href="#custom-content-below-rewards" role="tab"
                               aria-controls="custom-content-below-rewards" aria-selected="false">المكافآت</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white @if(session('tab_id') == 6) active @endif"
                               id="custom-content-below-discounts-tab" data-toggle="pill"
                               href="#custom-content-below-discounts" role="tab"
                               aria-controls="custom-content-below-discounts" aria-selected="false">الحسومات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white @if(session('tab_id') == 7) active @endif"
                               id="custom-content-below-advances-tab" data-toggle="pill"
                               href="#custom-content-below-advances" role="tab"
                               aria-controls="custom-content-below-advances" aria-selected="false">السُلف</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white @if(session('tab_id') == 8) active @endif"
                               id="custom-content-below-vacations-tab" data-toggle="pill"
                               href="#custom-content-below-vacations" role="tab"
                               aria-controls="custom-content-below-vacations" aria-selected="false">الإجازات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white @if(session('tab_id') == 9) active @endif"
                               id="custom-content-below-bonuses-tab" data-toggle="pill"
                               href="#custom-content-below-bonuses" role="tab"
                               aria-controls="custom-content-below-bonuses" aria-selected="false">العلاوات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white @if(session('tab_id') == 10) active @endif"
                               id="custom-content-below-evaluations-tab" data-toggle="pill"
                               href="#custom-content-below-evaluations" role="tab"
                               aria-controls="custom-content-below-evaluations" aria-selected="false">التقييمات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white @if(session('tab_id') == 11) active @endif"
                               id="working-hours-tab" data-toggle="pill"
                               href="#working-hours" role="tab"
                               aria-controls="working-hours-tab" aria-selected="false">أوقات الدوام</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="tab-content" id="custom-content-below-tabContent">
                        <div
                            class="tab-pane fade @if(session('tab_id') == null) show active @endif  @if(session('tab_id') == 1) active show @endif"
                            id="custom-content-below-home" role="tabpanel"
                            aria-labelledby="custom-content-below-home-tab">
                            <div class="p-2">
                                <div class="row">
                                    <div class="col-md-8 p-5">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">الاسم :</label>
                                                    <input onchange="update_user_ajax('name',this.value)"
                                                           class="form-control" value="{{ $data->name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">البريد الالكتروني :</label>
                                                    <input onchange="update_user_ajax('email',this.value)"
                                                           class="form-control" value="{{ $data->email }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">كلمة المرور :</label>
                                                    <input onchange="update_user_ajax('password',this.value)"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div
                                                        class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                        <input
                                                            onchange="update_user_ajax('user_status',(this.checked) ?1:0)"
                                                            @if($data->user_status == 1) checked @endif type="checkbox"
                                                            class="custom-control-input" id="customSwitch3">
                                                        <label class="custom-control-label" for="customSwitch3">حالة
                                                            المستخدم</label>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--                                            <div class="col-md-4">--}}
                                            {{--                                                <div class="form-group">--}}
                                            {{--                                                    <label for="">حالة المستخدم :</label>--}}
                                            {{--                                                    @if($data->user_status == 1)--}}
                                            {{--                                                        <span class="form-control text-success">فعال</span>--}}
                                            {{--                                                    @elseif($data->user_status == 0)--}}
                                            {{--                                                        <span class="text-danger form-control">غير فعال</span>--}}
                                            {{--                                                    @endif--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">رقم الهاتف الاول :</label>
                                                    <input onchange="update_user_ajax('user_phone1',this.value)"
                                                           class="form-control" value="{{ $data->user_phone1 }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">رقم الهاتف الثاني :</label>
                                                    <input onchange="update_user_ajax('user_phone2',this.value)"
                                                           class="form-control"
                                                           value="{{ empty($data->user_phone2) ? 'لا يوجد' : $data->user_phone2}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">الراتب الاساسي</label>
                                                    <input onchange="update_user_ajax('main_salary',this.value)"
                                                           type="text" value="{{ $data->main_salary }}"
                                                           class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">ملاحظات : </label>
                                                    <textarea onchange="update_user_ajax('user_notes',this.value)"
                                                              class="form-control" name="" id="" cols="30"
                                                              rows="3">{{ $data->user_notes }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">العنوان :</label>
                                                    <textarea onchange="update_user_ajax('user_address',this.value)"
                                                              class="form-control" name="" id="" cols="30"
                                                              rows="3">{{ $data->user_address }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pt-5 text-center">
                                        <div class="form-group text-center">
                                            @if(empty($data->user_photo))
                                                <img id="image_preview_container" width="150"
                                                     src="{{ asset('storage/user_photo/'.$data->user_photo) }}" alt="">
                                            @else
                                                <img id="image_preview_container" width="150"
                                                     src="{{ asset('storage/user_photo/'.$data->user_photo) }}" alt="">
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-center">{{ $data->name }}</h4>
                                            <hr>
                                            <form method="POST" enctype="multipart/form-data" id="upload_image_form">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input class="form-control" type="file" name="image"
                                                                   placeholder="Choose image" id="image">
                                                            <span
                                                                class="text-danger">{{ $errors->first('title') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-primary">رفع الصورة
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            {{--                                            <p>يحتوي هذا القسم على المعلومات الأساسية للموظف</p>--}}
                                            {{--                                            <a href="{{ route('users.employees.edit',['id'=>$data->id]) }}" class="btn btn-info">تعديل بيانات الموظف</a>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade @if(session('tab_id') == 2) active show @endif"
                             id="custom-content-below-attendance" role="tabpanel"
                             aria-labelledby="custom-content-below-attendance-tab">
                            <div class="p-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button onclick="add_attendance()" class="btn btn-dark mb-2">تسجيل حضور</button>
                                        <a href="{{ route('users.attendance.export_pdf') }}" class="btn btn-dark mb-2">تصدير pdf</a>
                                    </div>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                            rowspan="1" colspan="1" aria-sort="ascending">#
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1">وقت الدخول
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1">وقت الخروج
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1">الحالة
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1">الملاحظات
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if ($bfo_attendances->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">لا توجد نتائج</td>
                                        </tr>
                                    @endif
                                    @foreach ($bfo_attendances as $key)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $key->in_time }}</td>
                                            <td>{{ $key->out_time }}</td>
                                            <td>{{ $key->status}}</td>
                                            <td>{{$key->note}}</td>
                                            <td>
                                                <button class="btn btn-dark mb-2"
                                                        onclick="edit_out_time_attendance('{{$key->note}}' , {{$key->id}} , '{{$key->activity_type}}')">
                                                    تسجيل مغادرة
                                                </button>
                                                <button class="btn btn-danger btn-sm"
                                                        onclick="delete_bfo_attendance({{$key->id}})"><span
                                                        class="fa fa-trash pt-1"></span></button>
                                                <button class="btn btn-success btn-sm"
                                                        onclick="edit_attendance({{$key->id}} , '{{$key->activity_type}}' , '{{$key->note}}' , '{{$key->in_time}}' , '{{$key->out_time}}')">
                                                    <span class="fa fa-edit pt-1"></span></button>
                                                {{-- <a class="btn btn-dark btn-sm" href="{{ route('users.employees.details', ['id' => $key->id]) }}"><span class="fa fa-search"></span></a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$bfo_attendances->links()}}

                            </div>
                        </div>
                        <div class="tab-pane fade @if(session('tab_id') == 3) active show @endif" id="salaries"
                             role="tabpanel" aria-labelledby="salaries-tab">
                            <div class="p-2">
                                <div class="row">
                                    <button onclick="add_salary()" class="btn btn-dark mb-2">اضافة راتب</button>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>القيمة</th>
                                        <th>الشهر</th>
                                        <th>السنة</th>
                                        <th>عدد الايام</th>
                                        <th>وقت الاضافة</th>
                                        <th>الحالة</th>
                                        <th>العمليات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if ($salaries->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">لا توجد نتائج</td>
                                        </tr>
                                    @endif
                                    @foreach ($salaries as $key)
                                        <tr>
                                            <td>{{ $key->salary_value }}</td>
                                            <td>{{ $key->month }}</td>
                                            <td>{{ $key->year }}</td>
                                            <td>{{ $key->days }}</td>
                                            <td>{{ $key->insert_at }}</td>
                                            <td>{{ $key->status }}</td>
                                            <td>
                                                <button
                                                    onclick="edit_salary({{ $key->id }},{{ $key->salary_value }},{{ $key->month }},{{ $key->year }},{{ $key->days }})"
                                                    data-toggle="modal" data-target="#edit_salary_modal"
                                                    class="btn btn-success btn-sm"><span class="fa fa-edit"></span>
                                                </button>
                                                <a href="" class="btn btn-danger btn-sm"><span
                                                        class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$bfo_attendances->links()}}

                            </div>
                        </div>
                        <div class="tab-pane fade @if(session('tab_id') == 5) active show @endif"
                             id="custom-content-below-rewards" role="tabpanel"
                             aria-labelledby="custom-content-below-attendance-tab">
                            <div class="p-2">
                                <div class="row">
                                    <button onclick="add_reward()" class="btn btn-dark mb-2">إضافة مكافأة</button>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="date" onkeyup="reward_change_date_by_ajax()" class="form-control"
                                               id="from_reward" value="{{date('Y-m-01')}}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" onkeyup="reward_change_date_by_ajax()" class="form-control"
                                               id="to_reward" value="{{date('Y-m-d')}}">
                                    </div>
                                </div>
                                <div id="reward_table">

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade @if(session('tab_id') == 6) active show @endif"
                             id="custom-content-below-discounts" role="tabpanel"
                             aria-labelledby="custom-content-below-discounts-tab">
                            <div class="p-2">
                                <div class="row">
                                    <button onclick="add_discount()" class="btn btn-dark mb-2">إضافة حسم</button>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="date" onkeyup="discount_change_date_by_ajax()" class="form-control"
                                               id="from_discount" value="{{date('Y-m-01')}}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" onkeyup="discount_change_date_by_ajax()" class="form-control"
                                               id="to_discount" value="{{date('Y-m-d')}}">
                                    </div>
                                </div>
                                <div id="discount_table">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade @if(session('tab_id') == 7) active show @endif"
                             id="custom-content-below-advances" role="tabpanel"
                             aria-labelledby="custom-content-below-advances-tab">
                            <div class="p-2">
                                <div class="row">
                                    <button onclick="add_advance()" class="btn btn-dark mb-2">إضافة سُلفة</button>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="date" onkeyup="advance_change_date_by_ajax()" class="form-control"
                                               id="from_advance" value="{{date('Y-m-01')}}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" onkeyup="advance_change_date_by_ajax()" class="form-control"
                                               id="to_advance" value="{{date('Y-m-d')}}">
                                    </div>
                                </div>
                                <div id="advance_table">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade @if(session('tab_id') == 8) active show @endif"
                             id="custom-content-below-vacations" role="tabpanel"
                             aria-labelledby="custom-content-below-vacations-tab">
                            <div class="p-2">
                                <div class="row">
                                    <button onclick="add_vacations()" class="btn btn-dark mb-2">إضافة إجازة</button>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="date" onkeyup="vacations_change_date_by_ajax()"
                                               class="form-control" id="from_vacations" value="{{date('Y-01-01')}}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" onkeyup="vacations_change_date_by_ajax()"
                                               class="form-control" id="to_vacations" value="{{date('Y-m-d')}}">
                                    </div>
                                </div>
                                <div id="vacations_table">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade @if(session('tab_id') == 9) active show @endif"
                             id="custom-content-below-bonuses" role="tabpanel"
                             aria-labelledby="custom-content-below-bonuses-tab">
                            <div class="p-2">
                                <div class="row">
                                    <button onclick="add_bonuses()" class="btn btn-dark mb-2">إضافة علاوة</button>
                                </div>
                                <div id="bonuses_table">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                                rowspan="1" colspan="1" aria-sort="ascending">#
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1">القيمة
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1">النوع
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1">العمليات
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if ($employees_bonuses->isEmpty())
                                            <tr>
                                                <td colspan="4" class="text-center">لا توجد نتائج</td>
                                            </tr>
                                        @endif
                                        @foreach ($employees_bonuses as $key)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $key->value }}</td>
                                                <td>
                                                    @if ($key->type == 0)
                                                        نسبة
                                                    @elseif($key->type == 1)
                                                        عدد (مبلغ محدد)
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-sm"
                                                            onclick="edit_bonus({{$key->id}} , {{$key->value}} , {{$key->type}} , '{{$key->notes}}')">
                                                        <span class="fa fa-edit pt-1"></span></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade @if(session('tab_id') == 10) active show @endif"
                             id="custom-content-below-evaluations" role="tabpanel"
                             aria-labelledby="custom-content-below-evaluations-tab">
                            <div class="p-2">
                                <div class="row">
                                    <button onclick="add_evaluations()" class="btn btn-dark mb-2">إضافة تقييم</button>
                                </div>
                                <div id="evaluations_table">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                                rowspan="1" colspan="1" aria-sort="ascending">#
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1">التقييم
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1">الملف المرفق
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1">العمليات
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if ($employees_evaluations->isEmpty())
                                            <tr>
                                                <td colspan="4" class="text-center">لا توجد نتائج</td>
                                            </tr>
                                        @endif
                                        @foreach ($employees_evaluations  as $key)
                                            <tr>
                                                <td>{{$loop->index + 1}}</td>
                                                <td>{{$key->notes }}</td>
                                                <td>
                                                    <a target="_blank"
                                                       href="{{ asset('storage/employees_evaluations/'.$key->attachment) }}"
                                                       download="attachment">تحميل الملف</a>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-sm"
                                                            onclick="edit_evaluations({{$key->id}} , '{{$key->notes}}' , '{{$key->attachment}}')">
                                                        <span class="fa fa-edit pt-1"></span></button>
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade @if(session('tab_id') == 11) active show @endif" id="working-hours"
                             role="tabpanel" aria-labelledby="working-hours-tab">
                            <div class="p-2">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="">نوع الدوام</label>
                                        <select onchange="update_permanent_type(this.value)" class="form-control"
                                                name="" id="">
                                            <option @if($data->permanent_type == 'full_time') selected
                                                    @endif value="full_time">دوام كامل
                                            </option>
                                            <option @if($data->permanent_type == 'part_time') selected
                                                    @endif value="part_time">دوام جزئي
                                            </option>
                                            <option @if($data->permanent_type == 'hourly_work') selected
                                                    @endif value="hourly_work">دوام بالساعة
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <table class="table table-sm table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>الايام</th>
                                            <th>بداية الدوام</th>
                                            <th>نهاية الدوام</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <input
                                                    @if(!empty(\App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','saturday')->first())) @if(\App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','saturday')->first()->status == 'active') checked
                                                    @endif @endif onchange="create_working_houre('saturday','status',(this.checked)?'active':'not_active')"
                                                    id="saturday" type="checkbox">
                                                <label for="saturday">السبت</label>
                                            </td>
                                            <td>
                                                <input
                                                    value="{{ \App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','saturday')->first()->start_time ?? ''}}"
                                                    onchange="create_working_houre('saturday','start_time',this.value)"
                                                    class="form-control" type="time">
                                            </td>
                                            <td>
                                                <input
                                                    value="{{ \App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','saturday')->first()->end_time ?? ''}}"
                                                    onchange="create_working_houre('saturday','end_time',this.value)"
                                                    class="form-control" type="time">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input
                                                    @if(!empty(\App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','sunday')->first())) @if(\App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','sunday')->first()->status == 'active') checked
                                                    @endif @endif  onchange="create_working_houre('sunday','status',(this.checked)?'active':'not_active')"
                                                    id="sunday" type="checkbox">
                                                <label for="sunday">الاحد</label>
                                            </td>
                                            <td>
                                                <input
                                                    value="{{ \App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','sunday')->first()->start_time ?? ''}}"
                                                    onchange="create_working_houre('sunday','start_time',this.value)"
                                                    class="form-control" type="time">
                                            </td>
                                            <td>
                                                <input
                                                    value="{{ \App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','sunday')->first()->end_time ?? ''}}"
                                                    onchange="create_working_houre('sunday','end_time',this.value)"
                                                    class="form-control" type="time">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input
                                                    @if(!empty(\App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','monday')->first())) @if(\App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','monday')->first()->status == 'active') checked
                                                    @endif @endif  onchange="create_working_houre('monday','status',(this.checked)?'active':'not_active')"
                                                    id="monday" type="checkbox">
                                                <label for="monday">الاثنين</label>
                                            </td>
                                            <td>
                                                <input
                                                    value="{{ \App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','monday')->first()->start_time ?? ''}}"
                                                    onchange="create_working_houre('monday','start_time',this.value)"
                                                    class="form-control" type="time">
                                            </td>
                                            <td>
                                                <input
                                                    value="{{ \App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','monday')->first()->end_time ?? ''}}"
                                                    onchange="create_working_houre('monday','end_time',this.value)"
                                                    class="form-control" type="time">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input
                                                    @if(!empty(\App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','tuesday')->first())) @if(\App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','tuesday')->first()->status == 'active') checked
                                                    @endif @endif onchange="create_working_houre('tuesday','status',(this.checked)?'active':'not_active')"
                                                    id="tuesday" type="checkbox">
                                                <label for="tuesday">الثلاثاء</label>
                                            </td>
                                            <td>
                                                <input
                                                    value="{{ \App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','tuesday')->first()->start_time ?? ''}}"
                                                    onchange="create_working_houre('tuesday','start_time',this.value)"
                                                    class="form-control" type="time">
                                            </td>
                                            <td>
                                                <input
                                                    value="{{ \App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','tuesday')->first()->end_time ?? ''}}"
                                                    onchange="create_working_houre('tuesday','end_time',this.value)"
                                                    class="form-control" type="time">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input
                                                    @if(!empty(\App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','wednesday')->first())) @if(\App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','wednesday')->first()->status == 'active') checked
                                                    @endif @endif onchange="create_working_houre('wednesday','status',(this.checked)?'active':'not_active')"
                                                    id="wednesday" type="checkbox">
                                                <label for="wednesday">الاربعاء</label>
                                            </td>
                                            <td>
                                                <input
                                                    value="{{ \App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','wednesday')->first()->start_time ?? ''}}"
                                                    onchange="create_working_houre('wednesday','start_time',this.value)"
                                                    class="form-control" type="time">
                                            </td>
                                            <td>
                                                <input
                                                    value="{{ \App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','wednesday')->first()->end_time ?? ''}}"
                                                    onchange="create_working_houre('wednesday','end_time',this.value)"
                                                    class="form-control" type="time">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input
                                                    @if(!empty(\App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','thursday')->first())) @if(\App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','thursday')->first()->status == 'active') checked
                                                    @endif @endif onchange="create_working_houre('thursday','status',(this.checked)?'active':'not_active')"
                                                    id="thursday" type="checkbox">
                                                <label for="thursday">الخميس</label>
                                            </td>
                                            <td>
                                                <input
                                                    value="{{ \App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','thursday')->first()->start_time ?? ''}}"
                                                    onchange="create_working_houre('thursday','start_time',this.value)"
                                                    class="form-control" type="time">
                                            </td>
                                            <td>
                                                <input
                                                    value="{{ \App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','thursday')->first()->end_time ?? ''}}"
                                                    onchange="create_working_houre('thursday','end_time',this.value)"
                                                    class="form-control" type="time">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input
                                                    @if(!empty(\App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','friday')->first())) @if(\App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','friday')->first()->status == 'active') checked
                                                    @endif @endif onchange="create_working_houre('friday','status',(this.checked)?'active':'not_active')"
                                                    id="friday" type="checkbox">
                                                <label for="friday">الجمعة</label>
                                            </td>
                                            <td>
                                                <input
                                                    value="{{ \App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','friday')->first()->start_time ?? ''}}"
                                                    onchange="create_working_houre('friday','start_time',this.value)"
                                                    class="form-control" type="time">
                                            </td>
                                            <td>
                                                <input
                                                    value="{{ \App\Models\WorkingHoursModel::where('employee_id',$data->id)->where('day','friday')->first()->end_time ?? ''}}"
                                                    onchange="create_working_houre('friday','end_time',this.value)"
                                                    class="form-control" type="time">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                @include('admin.hr.employees.modals.attendanceCreate')
                @include('admin.hr.employees.modals.attendanceEditOutTime')
                @include('admin.hr.employees.modals.attendanceDelete')
                @include('admin.hr.employees.modals.attendanceEdit')
                @include('admin.hr.employees.modals.rewardCreate')
                @include('admin.hr.employees.modals.rewardEdit')
                @include('admin.hr.employees.modals.discountCreate')
                @include('admin.hr.employees.modals.discountEdit')
                @include('admin.hr.employees.modals.advanceCreate')
                @include('admin.hr.employees.modals.advanceEdit')
                @include('admin.hr.employees.modals.vacationsCreate')
                @include('admin.hr.employees.modals.vacationsEdit')
                @include('admin.hr.employees.modals.bonusesCreate')
                @include('admin.hr.employees.modals.bonusesEdit')
                @include('admin.hr.employees.modals.evaluationsCreate')
                @include('admin.hr.employees.modals.evaluationsEdit')
                @include('admin.hr.employees.modals.salariesCreate')
                @include('admin.hr.employees.modals.salaryEdit')
                @include('admin.accounting.expenses.modals.expensesCreate')
                @include('admin.accounting.expenses.modals.expensesEdit')
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script>
        function edit_evaluations(id, notes, attachment) {
            document.getElementById('id_evaluationsEdit').value = id;
            document.getElementById('notes_evaluationsEdit').value = notes;
            document.getElementById('attachment_evaluationsEdit').href = `{{asset('storage/employees_evaluations/${attachment}') }}`;
            $('#edit_evaluations_modal').modal('show');
        }

        function edit_salary(id, salary_value, month, year, days) {
            document.getElementById('id_salaryEdit').value = id;
            document.getElementById('salary_value_salaryEdit').value = salary_value;
            document.getElementById('month_salaryEdit').value = month;
            document.getElementById('year_salaryEdit').value = year;
            document.getElementById('days_salaryEdit').value = days;
            $('#edit_salary_modal').modal('show');
        }

        function add_evaluations() {
            $('#create_evaluations_modal').modal('show');
        }

        function edit_bonus(id, value, type, notes) {
            document.getElementById('id_bonusesEdit').value = id;
            document.getElementById('value_bonusesEdit').value = value;
            let select = document.getElementById('type_bonusesEdit');
            select.innerHTML = '';
            if (type == 0) {
                {
                    let option = document.createElement('option');
                    option.value = 0;
                    option.text = 'نسبة';
                    select.appendChild(option);
                }
                {
                    let option = document.createElement('option');
                    option.value = 1;
                    option.text = 'عدد (مبلغ محدد)';
                    select.appendChild(option);
                }
            } else if (type == 1) {
                {
                    let option = document.createElement('option');
                    option.value = 1;
                    option.text = 'عدد (مبلغ محدد)';
                    select.appendChild(option);
                }
                {
                    let option = document.createElement('option');
                    option.value = 0;
                    option.text = 'نسبة';
                    select.appendChild(option);
                }
            }
            document.getElementById('notes_bonusesEdit').value = notes;
            $('#edit_bonuses_modal').modal('show');
        }

        function add_bonuses() {
            $('#create_bonuses_modal').modal('show');
        }

        function edit_vacation(id, v_date, vacations_type_name, vacations_type_id, notes, attachement) {
            document.getElementById('id_vacationsEdit').value = id;
            document.getElementById('v_date_vacationsEdit').value = v_date;
            let selectElement = document.getElementById('vacations_type_id_vacationsEdit');
            selectElement.innerHTML = '';
            let option = document.createElement('option');
            option.value = vacations_type_id;
            option.text = vacations_type_name;
            selectElement.appendChild(option);
            let vacations_types = <?php echo json_encode($vacations_types) ?>;
            for (let i = 0; i < vacations_types.length; i++) {
                if (vacations_types[i].id !== vacations_type_id) {
                    option = document.createElement('option');
                    option.value = vacations_types[i].id;
                    option.text = vacations_types[i].type_name;
                    selectElement.appendChild(option);
                }
            }
            document.getElementById('notes_vacationsEdit').value = notes;
            document.getElementById('attachement_vacationsEdit').href = `{{asset('storage/vacations/${attachement}') }}`;
            $('#edit_vacations_modal').modal('show');
        }

        function vacations_change_date_by_ajax() {
            let from = document.getElementById('from_vacations').value;
            let to = document.getElementById('to_vacations').value;
            let employee_id = document.getElementById('employee_id').value;
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: "{{route('users.employees.vacations.vacations_change_date_by_ajax')}}",
                method: 'post',
                headers: headers,
                data: {
                    'from': from,
                    'to': to,
                    'employee_id': employee_id
                },
                success: function (data) {
                    $('#vacations_table').html(data.html);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            });
        }

        function add_vacations() {
            $('#create_vacations_modal').modal('show');
        }

        $(document).ready(function () {
            reward_change_date_by_ajax();
            discount_change_date_by_ajax();
            advance_change_date_by_ajax();
            vacations_change_date_by_ajax();
        });

        function advance_change_date_by_ajax() {
            let employee_id = document.getElementById('employee_id').value;
            let from = document.getElementById('from_advance').value;
            let to = document.getElementById('to_advance').value;
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: "{{ route('users.employees.advances.advance_change_date_by_ajax') }}",
                method: 'post',
                headers: headers,
                data: {
                    'from': from,
                    'to': to,
                    'employee_id': employee_id
                },
                success: function (data) {
                    $('#advance_table').html(data.html);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                }
            });
        }

        function discount_change_date_by_ajax() {
            let employee_id = document.getElementById('employee_id').value;
            let from = document.getElementById('from_discount').value;
            let to = document.getElementById('to_discount').value;
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: "{{ route('users.employees.discounts.discount_change_date_by_ajax') }}",
                method: 'post',
                headers: headers,
                data: {
                    'from': from,
                    'to': to,
                    'employee_id': employee_id
                },
                success: function (data) {
                    $('#discount_table').html(data.html);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                }
            });
        }

        function update_user_ajax(data_type, value) {
            let employee_id = document.getElementById('employee_id').value;
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: "{{ route('users.update_user_ajax') }}",
                method: 'post',

                headers: headers,
                data: {
                    'data_type': data_type,
                    'value': value,
                    'id': employee_id
                },
                success: function (data) {
                    if (data.success == 'true') {
                        toastr.success(data.message)
                    } else {
                        toastr.error(data.message)
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    // toastr.error(jqXHR.message)
                }
            });
        }

        function update_permanent_type(value) {
            let employee_id = document.getElementById('employee_id').value;
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: "{{ route('users.employees.permanent_type.update_permanent_type') }}",
                method: 'post',

                headers: headers,
                data: {
                    'employee_id': employee_id,
                    'permanent_type': value,
                },
                success: function (data) {
                    if (data.success == 'true') {
                        toastr.success(data.message)
                    } else {
                        toastr.error(data.message)
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    // toastr.error(jqXHR.message)
                }
            });
        }

        function create_working_houre(day, operation, value) {
            let employee_id = document.getElementById('employee_id').value;
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: "{{ route('users.employees.permanent_type.create_working_houre') }}",
                method: 'post',

                headers: headers,
                data: {
                    'employee_id': employee_id,
                    'day': day,
                    'operation': operation,
                    'value': value
                },
                success: function (data) {
                    console.log(data);
                    if (data.success == 'true') {
                        toastr.success(data.message)
                    } else {
                        toastr.error(data.message)
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    // toastr.error(jqXHR.message)
                }
            });
        }

        function reward_change_date_by_ajax() {
            let employee_id = document.getElementById('employee_id').value;
            let from = document.getElementById('from_reward').value;
            let to = document.getElementById('to_reward').value;
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: "{{ route('users.employees.rewards.reward_change_date_by_ajax') }}",
                method: 'post',
                headers: headers,
                data: {
                    'from': from,
                    'to': to,
                    'employee_id': employee_id
                },
                success: function (data) {
                    $('#reward_table').html(data.html);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                }
            });
        }

        function edit_advance(id, value, currency_id, currency_name, notes, attached_file) {
            document.getElementById('id_advanceEdit').value = id;
            document.getElementById('value_advanceEdit').value = value;
            document.getElementById('notes_advanceEdit').value = notes;
            let selectCurrency = document.getElementById('currency_id_advanceEdit');
            selectCurrency.innerHTML = "";
            let option = document.createElement('option');
            option.value = currency_id;
            option.text = currency_name;
            selectCurrency.append(option);
            selectCurrency.innerHTML += document.getElementById('currency_id_advanceCreate').innerHTML;
            document.getElementById('attached_file_advanceEdit').href = `{{ asset('storage/discounts_rewards_attachment/${attached_file}') }}`;
            $('#edit_advance_modal').modal('show');
        }

        function add_advance() {
            $('#create_advance_modal').modal('show');
        }

        function edit_discount(id, value, currency_id, currency_name, notes, attached_file) {
            document.getElementById('id_discountEdit').value = id;
            document.getElementById('value_discountEdit').value = value;
            document.getElementById('notes_discountEdit').value = notes;
            let selectCurrency = document.getElementById('currency_id_discountEdit');
            selectCurrency.innerHTML = "";
            let option = document.createElement('option');
            option.value = currency_id;
            option.text = currency_name;
            selectCurrency.append(option);
            selectCurrency.innerHTML += document.getElementById('currency_id_discountCreate').innerHTML;
            document.getElementById('attached_file_discountEdit').href = `{{ asset('storage/discounts_rewards_attachment/${attached_file}') }}`;
            $('#edit_discount_modal').modal('show');
        }

        function add_discount() {
            $('#create_discount_modal').modal('show');
        }

        function edit_reward(id, value, currency_id, currency_name, notes, attached_file) {
            document.getElementById('id_rewardEdit').value = id;
            document.getElementById('value_rewardEdit').value = value;
            document.getElementById('notes_rewardEdit').value = notes;
            let selectCurrency = document.getElementById('currency_id_rewardEdit');
            selectCurrency.innerHTML = "";
            let option = document.createElement('option');
            option.value = currency_id;
            option.text = currency_name;
            selectCurrency.append(option);
            selectCurrency.innerHTML += document.getElementById('currency_id_rewardCreate').innerHTML;
            document.getElementById('attached_file_rewardEdit').href = `{{ asset('storage/discounts_rewards_attachment/${attached_file}') }}`;
            $('#edit_reward_modal').modal('show');
        }

        function add_reward() {
            $('#create_reward_modal').modal('show');
        }

        function add_attendance() {
            $('#attendance_in_time').modal('show');
        }

        function add_salary() {
            $('#create_salary_modal').modal('show');
        }

        function edit_out_time_attendance(note, bfo_attendance_id, activity_type) {
            document.getElementById('bfo_attendance_id_attendanceEditOutTimeModal').value = bfo_attendance_id;
            document.getElementById('notes_attendanceEditOutTimeModal').value = note;
            let selectElement = document.getElementById('activity_type');
            selectElement.innerHTML = "";
            let activityTypes = ['دوام', 'خاص', 'ميداني'];
            let option = document.createElement('option');
            option.value = activity_type;
            option.text = activity_type;
            selectElement.appendChild(option);
            activityTypes.forEach(function (type) {
                if (type !== activity_type) {
                    let option = document.createElement('option');
                    option.value = type;
                    option.text = type;
                    selectElement.appendChild(option);
                }
            });
            $('#attendance_edit_out_time').modal('show');
        }

        function delete_bfo_attendance(id) {
            document.getElementById('bfo_attendance_id_attendanceDeleteModal').value = id;
            $('#attendance_delete').modal('show');
        }

        function edit_attendance(bfo_attendance_id, activity_type, notes, in_time, out_time) {
            let selectElement = document.getElementById('activity_type_edit_modal');
            selectElement.innerHTML = "";
            let activityTypes = ['دوام', 'خاص', 'ميداني'];
            let option = document.createElement('option');
            option.value = activity_type;
            option.text = activity_type;
            selectElement.appendChild(option);
            activityTypes.forEach(function (type) {
                if (type !== activity_type) {
                    let option = document.createElement('option');
                    option.value = type;
                    option.text = type;
                    selectElement.appendChild(option);
                }
            });
            document.getElementById('notes_edit_modal').value = notes;
            document.getElementById('in_time_time_edit_modal').value = in_time.split(' ')[1];
            document.getElementById('in_time_date_edit_modal').value = in_time.split(' ')[0];
            document.getElementById('out_time_time_edit_modal').value = out_time.split(' ')[1];
            document.getElementById('out_time_date_edit_modal').value = out_time.split(' ')[0];
            if (out_time !== '') {

            }
            document.getElementById('bfo_attendance_id_attendanceEdit').value = bfo_attendance_id;
            $('#edit_attendance').modal('show');
        }

        function edit_expenses(data) {
            if (data.files === '') {
                $('#check_attachment').css('display', 'block')
            }
            $('#expenses_id').val(data.id);
            $('#expense_date_edit_expenses').val(data.expense_date);
            $('#description_edit_expenses').val(data.description);
            $('#amount_edit_expenses').val(data.amount);
            $('#title_edit_expenses').val(data.title);
            $('#repeat_every_edit_expenses').val(data.repeat_every);
            $('#repeat_type_edit_expenses').val(data.repeat_type);
            $('#no_of_cycles_edit_expenses').val(data.no_of_cycles);

            let selectCurrency = document.getElementById('category_id_edit_expenses');
            selectCurrency.innerHTML = "";
            let option = document.createElement('option');
            option.value = data.category_id;
            option.text = data.expenses_category.title;
            selectCurrency.append(option);
            selectCurrency.innerHTML += document.getElementById('category_id_edit_expenses').innerHTML;

            $('#edit_expenses_modal').modal('show');
        }

        $(document).ready(function (e) {
            $('#image').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
            $('#upload_image_form').submit(function (e) {
                e.preventDefault();
                let employee_id = document.getElementById('employee_id').value;
                var formData = new FormData(this);
                formData.append('id', employee_id);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('users.upload_image') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) => {
                        toastr.success(data.message);
                        this.reset();
                    },
                    error: function (jqXHR) {
                        console.log(jqXHR.responseText);
                    }
                });
            })
        })

        function if_checked() {
            var checkbox = document.getElementById("checkbox");
            var recurring_form = document.getElementById("recurring_form");

            if (checkbox.checked === true) {
                recurring_form.style.display = "block";
            } else {
                recurring_form.style.display = "none";
            }
        }

        function if_checked_for_edit(value) {
            // var checkbox = document.getElementById("checkbox");
            var recurring_form = document.getElementById("recurring_form_edit");
            if (value === true) {
                recurring_form.style.display = "block";
            } else {
                recurring_form.style.display = "none";
            }
        }

        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            $("input[data-bootstrap-switch]").each(function () {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })
        });
    </script>
@endsection
