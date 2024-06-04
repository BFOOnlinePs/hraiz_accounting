@extends('home')
@section('title')
    مدخلات الانتاج
@endsection
@section('header_title')
     <span>{{ $production_lines->production_name }}</span>
@endsection
@section('header_link')
    خطوط الانتاج
@endsection
@section('header_title_link')
    مدخلات الانتاج
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

    <style>
        .image-container {
            position: relative;
            margin-bottom: 10px;
        }

        .remove-button {
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
        }

        .nav-tabs .nav-link.active {
            background-color: #17a2b8;
            color: white; /* Optionally, you can change the text color */
        }

        .nav-tabs .nav-link {
            background-color: #6c757d;
            color: white; /* Optionally, you can change the text color */
        }
    </style>
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h5 class="d-inline">مدخلات الانتاج</h5>
                        <button type="button" style="float: left" class="btn btn-sm btn-dark mb-2" data-toggle="modal" data-target="#create-production_inputs"><span class="fa fa-plus"></span> اضافة مدخل انتاج
                        </button>
                    </div>
                    <hr>
                    <div id="production_inputs_table">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>مخرجات الانتاج</h5>
                    <hr>
                    <row>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اسم الصنف المخرج</label>
                                <select onchange="update_product_and_qty_for_production_lines_ajax(this.value,'product')" name="" id="selected_product" class="select2bs4 form-control">
                                    @foreach($products as $key)
                                        <option @if($key->id == $production_lines->product_id) selected @endif value="{{ $key->id }}">{{ $key->product_name_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">عدد المخرجات</label>
                                    <input onchange="update_product_and_qty_for_production_lines_ajax(this.value,'qty')" id="production_output_count" type="text" value="{{ $production_lines->production_output_count }}" class="form-control" placeholder="عدد المخرجات">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">طول الصنف المخرج</label>
                                    <input readonly type="text" id="the_length_of_the_output_item" class="form-control" placeholder="طول الصنف المخرج">
                                </div>
                            </div>
                        </div>
                    </row>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h5>الملخص</h5>
                </div>
                <div class="card-body">
                    <div id="summery_production_inputs_table">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                            {{--                            <li class="nav-item">--}}
                            {{--                                <a class="nav-link {{ !session('tab_id') ?'active':'' }}" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">مدخلات الانتاج</a>--}}
                            {{--                            </li>--}}
                            <li class="nav-item">
                                <a class="nav-link {{ !session('tab_id') ?'active':'' }} " id="settings-tab" data-toggle="pill" href="#settings" role="tab" aria-controls="settings" aria-selected="false">اعدادات الالات</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ session('tab_id') == 2?'active':'' }}" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">مرفقات</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ session('tab_id') == 3?'active':'' }}" id="custom-content-below-messages-tab" data-toggle="pill" href="#custom-content-below-messages" role="tab" aria-controls="custom-content-below-messages" aria-selected="false">اوامر الانتاج</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="custom-content-below-tabContent">
                            <div class="tab-pane fade {{ !session('tab_id') ?'show active':'' }}" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-dark mt-3" data-toggle="modal" data-target="#create-setting">اضافة اعداد</button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div id="production_setting_table">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade {{ session('tab_id') == 2 ?'show active':'' }}" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <form class="row" id="submitform" enctype="multipart/form-data" action="#">
                                            <div class="col-md-3">
                                                <input name="photo" id="photo" type="file" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <button id="submitBtn" type="button" class="btn btn-success btn-sm">رفع الصورة</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="list_image">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade {{ session('tab_id') == 3?'show active':'' }}" id="custom-content-below-messages" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
                                <button class="btn btn-dark mt-3" data-toggle="modal" data-target="#create-production_orders">
                                    اضافة امر انتاج
                                </button>
                                <div id="production_order_table">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="create-production_inputs">
        <div class="modal-dialog modal-xl">
            <form action="{{ route('production.production_inputs.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="production_lines_id" value="{{ $production_input }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة مدخل للانتاج</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
{{--                    <div class="modal-body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">المنتج</label>--}}
{{--                                    <select class="form-control select2bs4" required name="product_id" id="">--}}
{{--                                        <option value="">اختر منتج ...</option>--}}
{{--                                        @foreach($products as $key)--}}
{{--                                            <option value="{{ $key->id }}">{{ $key->product_name_ar }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">اضافة صورة</label>--}}
{{--                                    <input id="imageInput" name="attachment[]" type="file" class="form-control">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div id="images" class="col-md-12">--}}

{{--                            </div>--}}
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">ملاحظات</label>--}}
{{--                                    <textarea class="form-control" name="production_input_notes" id="" cols="30" rows="3"></textarea>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-5 col-sm-3">
                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="product_tab-tab" data-toggle="pill" href="#product_tab" role="tab" aria-controls="product_tab" aria-selected="true">صنف</a>
                                    <a class="nav-link" id="workers-tab" data-toggle="pill" href="#workers" role="tab" aria-controls="workers" aria-selected="false">عمال</a>
                                    <a class="nav-link" id="others-tab" data-toggle="pill" href="#others" role="tab" aria-controls="others" aria-selected="false">اخرى</a>
                                </div>
                            </div>
                            <div class="col-7 col-sm-9">
                                <div class="tab-content" id="vert-tabs-tabContent">
                                    <div class="tab-pane text-left fade active show" id="product_tab" role="tabpanel" aria-labelledby="product_tab">
                                        <div class="row">
                                            <form action="{{ route('production.production_inputs.create') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="operation" value="product">
                                                <input type="hidden" name="production_lines_id" value="{{ $production_input }}">
                                                    <div class="col-md-7">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">اختر صنف</label>
                                                                    <select required class="form-control select2bs4" name="product_id" id="">
                                                                        <option value="">اختر صنف ...</option>
                                                                        @foreach($products as $key)
                                                                            <option value="{{ $key->id }}">{{ $key->product_name_ar }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">العدد</label>
                                                                    <input type="number" value="1" min="1" name="qty" class="form-control" placeholder="العدد">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="">ملاحظات</label>
                                                                    <textarea class="form-control" name="production_input_notes" id="" cols="30" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-dark">حفظ</button>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="row text-center">
                                                            <div class="col-md-12">
                                                                <span style="font-size: 96px" class="fa fa-list"></span>
                                                            </div>
                                                        </div>
                                                        <h3 class="text-center mt-2">اضافة صنف الى مدخلات الانتاج</h3>
                                                        <hr>
                                                        <p class="text-center">يمكنك من خلال هذا النموذج اختيار الاصناف التي تدخل في عملية الانتاج</p>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="workers" role="tabpanel" aria-labelledby="workers-tab">
                                            <form action="{{ route('production.production_inputs.create') }}" method="post">
                                                <div class="row">
                                                @csrf
                                                <input type="hidden" name="operation" value="workers">
                                                    <input type="hidden" name="production_lines_id" value="{{ $production_input }}">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">اسم المدخل</label>
                                                                            <input type="text" class="form-control" value="عمال">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">التكلفة التقديرية</label>
                                                                            <input type="text" class="form-control" name="estimated_cost" placeholder="التكلفة التقديرية">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">العدد</label>
                                                                            <input type="text" name="qty" class="form-control" placeholder="العدد">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">ملاحظات</label>
                                                                            <textarea class="form-control" name="production_input_notes" id="" cols="30" rows="3"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button class="btn btn-dark">حفظ</button>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="row text-center">
                                                                    <div class="col-md-12">
                                                                        <span style="font-size: 96px" class="fa fa-list"></span>
                                                                    </div>
                                                                </div>
                                                                <h3 class="text-center mt-2">تكلفة عمالة الانتاج</h3>
                                                                <hr>
                                                                <p class="text-center">من خلال النموذج التالي يمكن تحديد عدد العمال والتكلفة التقديرية لانتاج وحدة واحدة من المنتج</p>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                    </div>
                                    <div class="tab-pane fade" id="others" role="tabpanel" aria-labelledby="others-tab">
                                            <form action="{{ route('production.production_inputs.create') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="operation" value="others">
                                                <input type="hidden" name="production_lines_id" value="{{ $production_input }}">
                                                <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">اسم المدخل</label>
                                                        <input type="text" name="production_input_name" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">التكلفة التقديرية</label>
                                                        <input type="text" class="form-control" name="estimated_cost" placeholder="التكلفة التقديرية">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">العدد</label>
                                                        <input type="text" name="qty" class="form-control" placeholder="العدد">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">ملاحظات</label>
                                                        <textarea class="form-control" name="production_input_notes" id="" cols="30" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <button class="btn btn-dark">حفظ</button>
                                                </div>

                                            </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
{{--                    <div class="modal-footer justify-content-between">--}}
{{--                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>--}}
{{--                        <button type="submit" class="btn btn-primary">حفظ</button>--}}
{{--                    </div>--}}
                </div>
            </form>

        </div>
    </div>

    <div class="modal fade" id="create-production_orders">
        <div class="modal-dialog modal-xl">
            <form action="{{ route('production.production_inputs.create_production_orders') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="production_line_id" value="{{ $production_lines->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة امر للانتاج</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">اسم الموظف</label>
                                    <select class="form-control" name="employee_id" id="">
                                        @foreach($employees as $key)
                                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="images" class="col-md-12">
                                <div class="form-group">
                                    <label for="">تاريخ التسليم</label>
                                    <input class="form-control text-center" name="submission_date" value="@php echo date('Y-m-d') @endphp" type="date">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">ملاحظات</label>
                                    <textarea class="form-control" name="notes" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <div class="modal fade" id="create-setting">
        <div class="modal-dialog modal-xl">
            <form action="{{ route('production.production_inputs.settings.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="production_line_id" value="{{ $production_lines->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة اعداد لخط الانتاج</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">اسم الاعداد</label>
                                    <input type="text" name="production_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">القيمة</label>
                                    <input type="text" name="production_value" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">الصورة</label>
                                    <input type="file" class="form-control" name="product_image">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">ملاحظات</label>
                                    <textarea class="form-control" name="production_description" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>

                </div>
            </form>

        </div>
    </div>

@endsection()

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
        $(document).ready(function () {
            production_setting_list();
            production_order_table_ajax();
            production_input_table_ajax();
            summery_production_inputs_table();
            the_length_of_the_output_item_ajax();
        })
        $(document).ready(function() {
            list_image();
            $('#imageInput').on('change', function() {
                var inputElement = this;
                var imagesDiv = $('#images');

                var newImageContainer = $('<div>').addClass('image-container');
                var removeButton = $('<button class="btn btn-danger btn-sm">').html('<span class="fa fa-trash"></span>').addClass('remove-button').on('click', function() {
                    newImageContainer.remove();
                });
                var newImage = $('<img>').attr('src', URL.createObjectURL(inputElement.files[0])).attr('alt', 'Uploaded Image').css('max-width', '100%');

                newImageContainer.append(removeButton, newImage);
                imagesDiv.append(newImageContainer);

                inputElement.value = '';
            });
        });

        function list_image() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('production.production_inputs.list_image') }}',
                method: 'post',
                headers: headers,
                data: {
                    'attachment_table_id': {{ $production_lines->id }}
                },
                success: function (data) {
                    $('#list_image').html(data.view);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });
        }

        $(function () {
            $('#submitBtn').on('click', (e) => {
                e.preventDefault();

                let formData = new FormData();
                let name = $("input[name=name]").val();
                let _token = $('meta[name="csrf-token"]').attr('content');
                var photo = $('#photo').prop('files')[0];

                formData.append('photo', photo);
                formData.append('name', name);
                formData.append('attachemnt_table_id', {{ $production_lines->id }})

                $.ajax({
                    url: '{{ route('production.production_inputs.upload_image') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': _token
                    },
                    success: (response) => {
                        if (response.success === 'true') {
                            $('#uploadedImage').attr('src', '/path/to/your/uploaded/images/' + response.message.attachment).show();
                            $('#noImageText').hide();
                            list_image();
                        }
                    },
                    error: (response) => {
                        alert('error');
                        console.log(response);
                    }
                });
            });
        });

        function delete_image(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('production.production_inputs.delete_image') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                },
                success: function (data) {
                    if(data.success == 'true'){
                        toastr.success(data.message);
                        list_image();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_product_and_qty_for_production_lines_ajax(value,operation) {
            if(operation == 'qty' && value == ''){
                alert('لا يجب ان يكون هذا الحقل فارغ');
                document.getElementById('production_output_count').value = 0;
            }
            else{
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '{{ route('production.production_inputs.update_product_and_qty_for_production_lines_ajax') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'value': value,
                        'production_line_id':{{ $production_lines->id }},
                        'operation': operation
                    },
                    success: function (data) {
                        if(data.success == 'true'){
                            if(operation == 'product'){
                                the_length_of_the_output_item_ajax();
                            }
                            toastr.success(data.message);
                            summery_production_inputs_table();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            }
        }

        function production_setting_list() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('production.production_inputs.settings.production_setting_list') }}',
                method: 'post',
                headers: headers,
                data: {
                    'production_line_id':{{ $production_lines->id }},
                },
                success: function (data) {
                    $('#production_setting_table').html(data.view);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function the_length_of_the_output_item_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('production.production_inputs.the_length_of_the_output_item_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'product_id':document.getElementById('selected_product').value,
                },
                success: function (data) {
                    if(data.success == 'true'){
                        document.getElementById('the_length_of_the_output_item').value = data.data.height;
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_production_order_status(id,value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('production.production_inputs.update_production_order_status') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id':id,
                    'status': value
                },
                success: function (data) {
                    if(data.success == 'true'){
                        toastr.success(data.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_product_line_inputs_ajax(id,operation,value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('production.production_inputs.update_product_line_inputs_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id':id,
                    'operation':operation,
                    'value':value
                },
                success: function (data) {
                    console.log(data)
                    if(data.success == 'true'){
                        production_input_table_ajax();
                        summery_production_inputs_table();
                        toastr.success(data.message);
                    }
                    else if(data.success == 'false'){
                        toastr.error(data.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function production_input_table_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('production.production_inputs.production_input_table_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'production_line_id':{{ $production_lines->id }},
                },
                success: function (data) {
                    if(data.success == 'true'){
                        $('#production_inputs_table').html(data.view)
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function delete_production_input_ajax(id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('production.production_inputs.delete_production_input_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id':id,
                },
                success: function (data) {
                    if(data.success == 'true'){
                        toastr.success(data.message);
                        production_input_table_ajax();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function production_order_table_ajax(page) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('production.production_inputs.production_order_table_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id':{{ $production_lines->id }},
                    'page': page
                },
                success: function (data) {
                    $('#production_order_table').html(data.view)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function summery_production_inputs_table() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('production.production_inputs.summery_production_inputs_table_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'production_line_id':{{ $production_lines->id }},
                },
                success: function (data) {
                    console.log(data);
                    $('#summery_production_inputs_table').html(data.view)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
        var page = 1;
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            production_order_table_ajax(page)
        });
    </script>
@endsection

