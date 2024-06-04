@extends('home')
@section('title')
    خطوط الانتاج
@endsection
@section('header_title')
    خطوط الانتاج
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    خطوط الانتاج
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="row">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6">
                    <input onkeyup="production_lines_table_ajax()" type="text" id="search_production_line" class="form-control" placeholder="البحث عن خط انتاج">
                </div>
                <div class="col-md-6">
                    <select onchange="production_lines_table_ajax()" class="form-control select2bs4" name="" id="product_id_selected">
                        <option value="">جميع المنتجات</option>
                        @foreach($products as $key)
                            <option value="{{ $key->id }}">{{ $key->product_name_ar }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card mt-3">
                {{--        <div class="card-header">--}}
                {{--            <h3 class="text-center">قائمة خطوط الانتاج</h3>--}}
                {{--        </div>--}}
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="production_lines_table">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-sm form-control btn-dark mb-2" data-toggle="modal" data-target="#modal-default">اضافة خط انتاج
            </button>
        </div>
    </div>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-xl">
{{--            <form action="{{ route('production.create') }}" method="post" enctype="multipart/form-data">--}}
{{--                @csrf--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header">--}}
{{--                        <h4 class="modal-title">اضافة خط انتاج</h4>--}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                            <span aria-hidden="true">&times;</span>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">المنتج</label>--}}
{{--                                    <select onchange="get_product_name_for_add_production_name_ajax()" class="form-control select2bs4" required name="product_id" id="selected_product">--}}
{{--                                        <option value="">اختر منتج ...</option>--}}
{{--                                        @foreach($products as $key)--}}
{{--                                            <option value="{{ $key->id }}">{{ $key->product_name_ar }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">اسم خط الانتاج</label>--}}
{{--                                    <input id="production_name" name="production_name" class="form-control" type="text"--}}
{{--                                           placeholder="اكتب اسم خط الانتاج" required>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">صورة المنتج</label>--}}
{{--                                    <div class="input-group">--}}
{{--                                        <div class="custom-file">--}}
{{--                                            <input type="file" name="production_image" class="custom-file-input"--}}
{{--                                                   id="exampleInputFile">--}}
{{--                                            <label class="custom-file-label" for="exampleInputFile">اختر ملف</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="input-group-append">--}}
{{--                                            <span class="input-group-text">رفع الصورة</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">ملاحظات</label>--}}
{{--                                    <textarea class="form-control" name="production_notes" id="" cols="30" rows="3"></textarea>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer justify-content-between">--}}
{{--                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>--}}
{{--                        <button type="submit" class="btn btn-dark">حفظ</button>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </form>--}}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة خط انتاج</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="production_lines_id">
                        <input type="hidden" id="production_output_count">
                        <input type="hidden" id="product_id_input_hidden">
                        <div class="row">
                            <div class="col-md-12">
                                    <div class="card-body p-0">
                                        <div class="bs-stepper linear">
                                            <div id="bs-stepper-loader">

                                            </div>
                                            <div class="bs-stepper-header" role="tablist">
                                                <div class="step active" data-target="#product-line-part">
                                                    <button type="button" class="step-trigger" role="tab" aria-controls="product-line-part" id="product-line-part-trigger" aria-selected="true">
                                                        <span class="bs-stepper-circle">1</span>
                                                        <span class="bs-stepper-label">معلومات الانتاج</span>
                                                    </button>
                                                </div>
                                                <div class="line"></div>
                                                <div class="step" data-target="#production-input-part">
                                                    <button type="button" class="step-trigger" role="tab" aria-controls="production-input-part" id="production-input-part-trigger" aria-selected="false" disabled="disabled">
                                                        <span class="bs-stepper-circle">2</span>
                                                        <span class="bs-stepper-label">مدخلات</span>
                                                    </button>
                                                </div>
                                                <div class="line"></div>
                                                <div class="step" data-target="#production-output-part">
                                                    <button type="button" class="step-trigger" role="tab" aria-controls="production-output-part" id="production-output-part-trigger" aria-selected="false" disabled="disabled">
                                                        <span class="bs-stepper-circle">3</span>
                                                        <span class="bs-stepper-label">مخرجات</span>
                                                    </button>
                                                </div>
                                                <div class="line"></div>
                                                <div class="step" data-target="#cost-of-production-output-part">
                                                    <button type="button" class="step-trigger" role="tab" aria-controls="cost-of-production-output-part" id="cost-of-production-output-part-trigger" aria-selected="false" disabled="disabled">
                                                        <span class="bs-stepper-circle">4</span>
                                                        <span class="bs-stepper-label">مخرجات</span>
                                                    </button>
                                                </div>
                                                <div class="line"></div>
{{--                                                <div class="step" data-target="#information-part">--}}
{{--                                                    <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger" aria-selected="false" disabled="disabled">--}}
{{--                                                        <span class="bs-stepper-circle">4</span>--}}
{{--                                                        <span class="bs-stepper-label">تكلفة مخرجات الانتاج</span>--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
                                            </div>
                                            <div class="bs-stepper-content">
                                                <div id="product-line-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="product-line-part-trigger">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">المنتج</label>
                                                                            <select onchange="get_product_name_for_add_production_name_ajax()" class="form-control select2bs4" required name="product_id" id="selected_product">
                                                                                <option value="">اختر منتج ...</option>
                                                                                @foreach($products as $key)
                                                                                    <option value="{{ $key->id }}">{{ $key->product_name_ar }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">اسم خط الانتاج</label>
                                                                            <input id="production_name" name="production_name" class="form-control" type="text"
                                                                                   placeholder="اكتب اسم خط الانتاج" required>
                                                                        </div>
                                                                    </div>
                                                                    <div hidden class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">صورة المنتج</label>
                                                                            <div class="input-group">
                                                                                <div class="custom-file">
                                                                                    <input type="file" name="production_image" class="custom-file-input"
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
                                                                        <div class="form-group">
                                                                            <label for="">ملاحظات</label>
                                                                            <textarea class="form-control" name="production_notes" id="production_notes" cols="30" rows="3"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div id="product_production_line_table">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary" id="submit-create-button" onclick="create_production_line_ajax()">التالي</button>
                                                </div>
                                                <div id="production-input-part" class="content" role="tabpanel" aria-labelledby="production-input-part-trigger">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="row">
{{--                                                                <div class="col-md-12">--}}
{{--                                                                    <div class="form-group">--}}
{{--                                                                        <label for="">اضافة صنف</label>--}}
{{--                                                                        <select style="display: inline" class="select2bs4" name="" id="product_id">--}}
{{--                                                                            <option value="">اختر صنف ...</option>--}}
{{--                                                                            @foreach($products as $key)--}}
{{--                                                                                <option value="{{ $key->id }}">{{ $key->product_name_ar }}</option>--}}
{{--                                                                            @endforeach--}}
{{--                                                                        </select>--}}
{{--                                                                        <button class="btn btn-success btn-sm" onclick="create_production_input_ajax('product')"><span class="fa fa-plus"></span></button>--}}
{{--                                                                    </div>--}}
{{--                                                                </div>--}}
                                                                <div class="col-md-12">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <button type="button" onclick="create_production_input_ajax('product')" class="btn btn-success btn-sm"><span class="fa fa-plus"></span></button>
                                                                        </div>
                                                                        <select style="display: inline" class="select2bs4" name="" id="product_id">
                                                                            <option value="">اختر صنف ...</option>
                                                                            @foreach($products as $key)
                                                                                <option value="{{ $key->id }}">{{ $key->product_name_ar }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <button onclick="create_production_input_ajax('worker')" type="button" class="btn btn-success btn-sm"><span class="fa fa-plus"></span></button>
                                                                        </div>
                                                                        <input readonly type="text" value="عمال" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div id="production_line_input_table">

                                                            </div>
                                                        </div>
                                                    </div>
{{--                                                    <button class="btn btn-primary" onclick="stepper.previous()">السابق</button>--}}
                                                    <button class="btn btn-primary" onclick="stepper.next()">التالي</button>
                                                </div>
                                                <div id="production-output-part" class="content" role="tabpanel" aria-labelledby="production-output-part-trigger">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="col-md-7">
                                                                <div class="form-group">
                                                                    <label for="">اسم الصنف</label>
                                                                    <input readonly id="production_line_name" type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="col-md-7">
                                                                <div class="form-group">
                                                                    <label for="">عدد وحدات المخرجات</label>
                                                                    <input id="" value="0" onkeyup="update_product_and_qty_for_production_lines_ajax(this.value,'qty')" type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="col-md-7">
                                                                <div class="form-group">
                                                                    <label for="">الطول</label>
                                                                    <input id="the_length_of_the_output_item" onchange="update_height_for_product_ajax(this.value)" type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary" onclick="stepper.previous()">السابق</button>
                                                    <button type="submit" class="btn btn-primary" onclick="production_output_part_button()">التالي</button>
                                                </div>
                                                <div id="cost-of-production-output-part" class="content" role="tabpanel" aria-labelledby="cost-of-production-output-part-trigger">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="cost_of_production_output_table">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary" onclick="redirect_if_save()">حفظ</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
{{--                    <div class="modal-footer justify-content-between">--}}
{{--                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>--}}
{{--                        <button type="button" class="btn btn-dark">حفظ</button>--}}
{{--                    </div>--}}

                </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            production_lines_table_ajax();
        });
        function production_lines_table_ajax(page){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('production.production_inputs.production_lines_table_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'search_production_line': document.getElementById('search_production_line').value,
                    'product_id': document.getElementById('product_id_selected').value,
                    'page': page,
                },
                success: function (data) {
                    if(data.success == 'true'){
                        $('#production_lines_table').html(data.view);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function get_product_name_for_add_production_name_ajax(){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('production.get_product_name_for_add_production_name_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'product_id': document.getElementById('selected_product').value,
                },
                success: function (data) {
                    if(data.success == 'true'){
                        document.getElementById('production_name').value = `خط - ${data.data.product_name_ar}`;
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function create_production_line_ajax(){
            if ($('#selected_product').val() === '' || $('#production_name').val() === ''){
                toastr.error('احد الحقول المطلوبة فارغة');
            }
            else{
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                document.getElementById('bs-stepper-loader').innerHTML = '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
                document.getElementById('submit-create-button').disabled = true;
                $.ajax({
                    url: '{{ route('production.create_production_line_ajax') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'product_id': document.getElementById('selected_product').value,
                        'production_name': document.getElementById('production_name').value,
                        'production_notes': document.getElementById('production_notes').value,
                    },
                    success: function (data) {
                        if(data.success == 'true'){
                            document.getElementById('bs-stepper-loader').remove();
                            document.getElementById('submit-create-button').disabled = false;
                            $('#production_lines_id').val(data.data.id);
                            $('#production_line_name').val(data.data.product.product_name_ar);
                            $('#product_id_input_hidden').val(data.data.product.id);
                            $('#the_length_of_the_output_item').val((data.data.product.height / data.data.production_output_count));
                            cost_of_production_output_table_ajax();
                            stepper.next();
                            // document.getElementById('production_name').value = `خط - ${data.data.product_name_ar}`;
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            }
        }

        function production_line_input_table(){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('production_line_input_table').innerHTML = '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            // document.getElementById('submit-create-button').disabled = true;
            $.ajax({
                url: '{{ route('production.production_line_input_table') }}',
                method: 'post',
                headers: headers,
                data: {
                    'production_lines_id':$('#production_lines_id').val(),
                },
                success: function (data) {
                    if(data.success == 'true'){
                        $('#production_line_input_table').html(data.view);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function create_production_input_ajax(operation){
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                // document.getElementById('bs-stepper-loader').innerHTML = '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
                // document.getElementById('submit-create-button').disabled = true;
                $.ajax({
                    url: '{{ route('production.create_production_input_ajax') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'production_lines_id':$('#production_lines_id').val(),
                        'product_id':(operation === 'worker')?'worker':$('#product_id').val(),
                    },
                    success: function (data) {
                        if(data.success == 'true'){
                            production_line_input_table();
                            cost_of_production_output_table_ajax();
                        }
                    },
                    error: function (xhr,jqXHR, textStatus, errorThrown) {
                        console.log(xhr.responseText);
                    }
                });

        }

        function delete_production_input_ajax(id){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            // document.getElementById('bs-stepper-loader').innerHTML = '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            // document.getElementById('submit-create-button').disabled = true;
            $.ajax({
                url: '{{ route('production.production_inputs.delete_production_input_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id':id,
                },
                success: function (data) {
                    if(data.success == 'true'){
                        production_line_input_table();
                        toastr.success(data.message);
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
                        'production_line_id':$('#production_lines_id').val(),
                        'operation': operation
                    },
                    success: function (data) {
                        if(data.success == 'true'){
                            $('#the_length_of_the_output_item').val(numberFormat(data.product.height / data.data.production_output_count));
                            $('#production_output_count').val(numberFormat(data.data.production_output_count));
                            // toastr.success(data.message);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            }
        }

        function cost_of_production_output_table_ajax() {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '{{ route('production.cost_of_production_output_table_ajax') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'production_lines_id':$('#production_lines_id').val(),
                    },
                    success: function (data) {
                        if(data.success == 'true'){
                            $('#cost_of_production_output_table').html(data.view);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR.responseText)
                    }
                });
        }

        function update_estimated_cost_ajax(id,value,operation) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                if(operation === 'estimated_cost'){
                    document.getElementById('estimated_cost_worker_loader_'+id).style.display = 'inline';
                }
                else{
                    document.getElementById('cost_per_unit_worker_loader_'+id).style.display = 'inline';
                }
                if(operation === 'estimated_cost'){
                    $(`#cost_per_unit_worker_${id}`).val(numberFormat((value/$('#production_output_count').val())));
                }
                else {
                    $(`#estimated_cost_worker_${id}`).val(numberFormat(value * ($('#production_output_count').val())));
                }
                $.ajax({
                    url: '{{ route('production.update_estimated_cost_ajax') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'id':id,
                        'value':(operation === 'estimated_cost')?(value):($(`#estimated_cost_worker_${id}`).val())
                    },
                    success: function (data) {
                        if(data.success == 'true'){
                            if(operation === 'estimated_cost'){
                                $(`#cost_per_unit_worker_${id}`).val(numberFormat((value/$('#production_output_count').val())));
                            }
                            else {
                                $(`#estimated_cost_worker_${id}`).val(numberFormat(value * ($('#production_output_count').val())));
                            }
                            if(operation === 'estimated_cost'){
                                document.getElementById('estimated_cost_worker_loader_'+id).style.display = 'none';
                            }
                            else{
                                document.getElementById('cost_per_unit_worker_loader_'+id).style.display = 'none';
                            }
                            toastr.success(data.message);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(jqXHR.responseText);
                    }
                });
        }

        function update_height_for_product_ajax(value) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '{{ route('production.update_height_for_product_ajax') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'product_id':$('#product_id_input_hidden').val(),
                        'value':value
                    },
                    success: function (data) {
                        if(data.success == 'true'){

                            toastr.success(data.message);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(jqXHR.responseText);
                    }
                });
        }

        function product_production_line_table_ajax() {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '{{ route('production.product_production_line_table_ajax') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'product_id':$('#selected_product').val(),
                    },
                    success: function (data) {
                        if(data.success === 'true'){
                            $('#product_production_line_table').html(data.view);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(jqXHR.responseText);
                    }
                });
        }

        $('#selected_product').on('change',function () {
            product_production_line_table_ajax();
        })

        function production_output_part_button(){
            cost_of_production_output_table_ajax();
            stepper.next();
        }

        function update_estimated_cost_for_worker(id,value,operation) {
            if(operation === 'estimated_cost'){
                $(`#cost_per_unit_worker_${id}`).val(value/$('#production_output_count').val());
            }
            else {
                $(`#estimated_cost_worker_${id}`).val(value * ($('#production_output_count').val()));
            }
        }
        var page = 1;
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            production_lines_table_ajax(page);
        });

        function redirect_if_save(){
            var productionLinesId = $('#production_lines_id').val();
            var redirectUrl = "{{ route('production.redirect_with_update_status_production_line', ['id' => ':id']) }}";
            redirectUrl = redirectUrl.replace(':id', productionLinesId);
            window.location.href = redirectUrl;
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection

