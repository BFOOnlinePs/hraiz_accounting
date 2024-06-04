@extends('home')
@section('title')
    تفاصيل شركة التأمين
@endsection
@section('header_title')
    تفاصيل شركة التأمين
@endsection
@section('header_link')
    المستخدمين
@endsection
@section('header_title_link')
    تفاصيل شركة التأمين
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">
        <div class="card-header text-center">
            <h5 class="text-bold">تفاصيل المورد ( {{ $data->name }} )</h5>
        </div>
        <div class="card-body">
            {{--            <form action="{{ route('users.supplier.create') }}" method="post" enctype="multipart/form-data">--}}

            <div class="row">
                @csrf
                <div class="col-md-4">
                    <div id="accordion">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseOne"
                                       aria-expanded="false">
                                        المعلومات العامة
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                                <div class="card-body">
                                    <div class="card-body p-4">
                                        <div class="row">
                                            <div class="col-md-8 p-5">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">الاسم :</label>
                                                            <input onchange="update_user_ajax('name',this.value)" class="form-control" value="{{ $data->name }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">الايميل :</label>
                                                            <input onchange="update_user_ajax('email',this.value)" class="form-control" value="{{ $data->email }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">رقم الهاتف الاول :</label>
                                                            <input onchange="update_user_ajax('user_phone1',this.value)" class="form-control" value="{{ $data->user_phone1 }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">رقم الهاتف الثاني :</label>
                                                            <input onchange="update_user_ajax('user_phone2',this.value)" class="form-control" value="{{ empty($data->user_phone2) ? 'لا يوجد' : $data->user_phone2}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">ملاحظات : </label>
                                                            <textarea onchange="update_user_ajax('user_notes',this.value)" class="form-control" name="" id="" cols="30"
                                                                      rows="3">{{ $data->user_notes }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">العنوان :</label>
                                                            <textarea onchange="update_user_ajax('user_address',this.value)" class="form-control" name="" id="" cols="30"
                                                                      rows="3">{{ $data->user_address }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                                <input onchange="update_user_ajax('user_status',(this.checked) ?1:0)" @if($data->user_status == 1) checked @endif type="checkbox" class="custom-control-input" id="customSwitch3">
                                                                <label class="custom-control-label" for="customSwitch3">حالة المستخدم</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--                                                <div class="col-md-12">--}}
                                                    {{--                                                    <div class="form-group">--}}
                                                    {{--                                                        <label for="">تصنيف المستخدم :</label>--}}
                                                    {{--                                                        <span class="form-control"></span>--}}
                                                    {{--                                                    </div>--}}
                                                    {{--                                                </div>--}}
                                                </div>
                                            </div>
                                            <div class="col-md-4 pt-5 text-center">
                                                <div class="form-group text-center">
                                                    @if(empty($data->user_photo))
                                                        <img id="image_preview_container" width="150" src="{{ asset('storage/user_photo/'.$data->user_photo) }}" alt="">
                                                    @else
                                                        <img id="image_preview_container" width="150" src="{{ asset('storage/user_photo/'.$data->user_photo) }}" alt="">
                                                    @endif
                                                </div>
                                                <div>
                                                    <h4 class="text-center">{{ $data->name }}</h4>
                                                    <hr>
                                                    <form method="POST" enctype="multipart/form-data" id="upload_image_form">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input class="form-control" type="file" name="image" placeholder="Choose image" id="image">
                                                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <button type="submit" class="btn btn-primary">رفع الصورة</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    {{--                                            <p>يحتوي هذا القسم على المعلومات الأساسية للموظف</p>--}}
                                                    {{--                                            <a href="{{ route('users.employees.edit',['id'=>$data->id]) }}" class="btn btn-info">تعديل بيانات الموظف</a>--}}
                                                </div>
                                            </div>
                                        </div>                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-danger">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseTwo"
                                       aria-expanded="false">
                                        معلومات البنك
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="collapse" data-parent="#accordion" style="">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>رقم حساب البنك :</label>
                                        <span
                                            class="form-control">{{ $data->user_account_number }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label>اسم البنك :</label>
                                        <span
                                            class="form-control">{{ $data->user_bank_name }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label>عنوان البنك :</label>
                                        <textarea disabled class="form-control" name="" id=""
                                                  cols="30"
                                                  rows="3">{{ $data->user_bank_address }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Swift code :</label>
                                        <span
                                            class="form-control">{{ $data->user_swift_code }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label>IBAN Number :</label>
                                        <span
                                            class="form-control">{{ $data->user_iban_number }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-info">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseThree"
                                       aria-expanded="true">
                                        معلومات التواصل
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="collapse show" data-parent="#accordion" style="">
                                <div class="card-body">
                                    <div class="card-body">
                                        <label for="">جهة التواصل</label>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#modal-default">
                                            اضافة جديد
                                        </button>
                                        <div class="modal fade" id="modal-default">
                                            <div class="modal-dialog">
                                                <form action="{{ route('company_contact_person.supplier.create') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="text" hidden name="company_id" value="{{ $data->id }}">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">اضافة جهة تواصل جديدة</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="">الاسم</label>
                                                                <input name="contact_name" class="form-control" type="text"
                                                                       placeholder="الاسم">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">رقم الهاتف</label>
                                                                <input name="mobile_number" class="form-control" type="text"
                                                                       placeholder="رقم الهاتف">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">البريد الالكتروني</label>
                                                                <input name="email" class="form-control" type="text"
                                                                       placeholder="البريد الالكتروني">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">رقم WhatsApp</label>
                                                                <input name="whats_app_number" class="form-control" type="text"
                                                                       placeholder="رقم الواتس اب">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">رقم WeChat</label>
                                                                <input name="wechat_number" class="form-control" type="text"
                                                                       placeholder="رقم وي شات">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">العنوان</label>
                                                                <textarea class="form-control" name="address" id="" cols="30"
                                                                          rows="2" placeholder="العنوان"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">الصورة</label>
                                                                <div class="custom-file">
                                                                    <input name="photo" type="file" class="custom-file-input"
                                                                           id="customFile">
                                                                    <label class="custom-file-label" for="customFile">تحميل
                                                                        صورة</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">اغلاق
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">حفظ</button>
                                                        </div>

                                                    </div>
                                                </form>

                                            </div>

                                        </div>

                                        <table style="font-size: 14px" id="contact_person_table"
                                               class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>الاسم</td>
                                                <td>العمليات</td>
                                                <td></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($company_contact_person as $key)
                                                <tr>
                                                    <td>{{ $key->id }}</td>
                                                    <td>{{ $key->contact_name }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn btn-dark">تفاصيل</button>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-danger">X</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-8">
                    <div>
                        <div class="card card-info">
                            <div class="card-header text-center">
                                <span>طلبات المورد</span>
                            </div>

                            <div class="card-body p-4">
                                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="example1"
                                                   class="table table-bordered table-striped dataTable dtr-inline"
                                                   aria-describedby="example1_info">
                                                <thead>
                                                <tr>
                                                    <th class="sorting sorting_asc" tabindex="0"
                                                        aria-controls="example1" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="Rendering engine: activate to sort column descending">
                                                        Rendering engine
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending">
                                                        Browser
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending">
                                                        Platform(s)
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending">
                                                        Engine version
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending">
                                                        CSS grade
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--                        <div class="col-md-12">--}}
                    {{--                            <button type="submit" class="btn btn-success btn-block"><i--}}
                    {{--                                    class="fa-solid fa-floppy-disk"></i> حفظ--}}
                    {{--                            </button>--}}
                    {{--                        </div>--}}
                </div>
            </div>

            {{--            </form>--}}

        </div>

    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        function update_user_ajax(data_type,value)
        {
            let user_id = {{ $data->id }};
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: "{{ route('users.update_user_ajax') }}",
                method: 'post',

                headers: headers,
                data: {
                    'data_type':data_type,
                    'value': value ,
                    'id':user_id
                },
                success: function(data) {
                    if(data.success == 'true'){
                        toastr.success(data.message)
                    }
                    else{
                        toastr.error(data.message)
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    // toastr.error(jqXHR.message)
                }
            });
        }

        $(document).ready(function (e) {
            $('#image').change(function (){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src',e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
            $('#upload_image_form').submit(function (e) {
                e.preventDefault();
                let user_id = {{ $data->id }};
                var formData = new FormData(this);
                formData.append('id',user_id);
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
                    error: function(jqXHR) {
                        console.log(jqXHR.responseText);
                    }
                });
            })
        })

    </script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>


    <script>
        function add_contact_person() {
            var contact_person_table = document.getElementById('contact_person_table');
            var count = {{ \App\Models\CompanyContactPersonModel::count() }};
            if (contact_person_table.rows.length == count + 1) {
                var new_row = contact_person_table.insertRow();
                var cell1 = new_row.insertCell();
                var cell2 = new_row.insertCell();
                var cell3 = new_row.insertCell();
                var cell4 = new_row.insertCell();
                cell1.innerText = '2';
                cell2.innerText = 'test2';
                cell3.innerHTML = '<button class="btn btn-sm btn-dark">تفاصيل</button>';
                cell4.innerHTML = '<button class="btn btn-sm btn-danger">X</button>';
            } else {
                alert('يرجى تعبئة الحقل الفارغ')
            }
            console.log(contact_person_table.rows.length);
            // console.log(count);

        }
    </script>
@endsection

