@extends('home')
@section('title')
    المنتجات
@endsection
@section('header_title')
    المنتجات
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    المنتجات
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <style>
        /* أنماط CSS لشاشة التحميل */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* خلفية شفافة لشاشة التحميل */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* يجعل شاشة التحميل فوق جميع العناصر الأخرى */
        }

        .loader {
            border: 4px solid #f3f3f3; /* لون الدائرة الخارجية */
            border-top: 4px solid #3498db; /* لون الدائرة الداخلية */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite; /* تأثير دوران */
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>

@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">
        <div class="card-header text-center">
            <span class="">تفاصيل الصنف ( <span>{{ $data->product_name_ar }}</span> )</span>
        </div>
        <div class="card-body">
            <div class="card card-outline card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if(!Session::has('tab_id')) active @endif @if(Session::has('tab_id')) @if(session('tab_id') == 1) active @endif  @endif " id="custom-tabs-three-product-details-tab" data-toggle="pill" href="#custom-tabs-three-product-details" role="tab" aria-controls="custom-tabs-three-product-details" aria-selected="true">معلومات الصنف</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Session::has('tab_id')) @if(session('tab_id') == 2) active @endif @endif" id="custom-tabs-three-product-supplier-tab" data-toggle="pill" href="#custom-tabs-three-product-supplier" role="tab" aria-controls="custom-tabs-three-product-supplier" aria-selected="false">مورد الصنف</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Session::has('tab_id')) @if(session('tab_id') == 3) active @endif @endif" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">توافق الصنف</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Session::has('tab_id')) @if(session('tab_id') == 4) active @endif @endif" id="custom-tabs-three-assembled-product-tab" data-toggle="pill" href="#custom-tabs-three-assembled-product" role="tab" aria-controls="custom-tabs-three-assembled-product" aria-selected="false">منتج مجمع</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Session::has('tab_id')) @if(session('tab_id') == 5) active @endif @endif" id="production_lines-tab" data-toggle="pill" href="#production_lines" role="tab" aria-controls="production_lines" aria-selected="false">خطوط الانتاج</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-three-tabContent">
                        <div class="tab-pane fade @if(!Session::has('tab_id')) show active @endif @if(Session::has('tab_id')) @if(session('tab_id') == 1) show active @endif @endif" id="custom-tabs-three-product-details" role="tabpanel" aria-labelledby="custom-tabs-three-product-details">
                            <form action="{{ route('product.update',['id'=>$data->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">رقم الصنف / Product Number</label>
                                                <input class="form-control" type="text"
                                                       value="{{ old('product_id',$data->product_id) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">اسم الصنف بالعربي / Product name arabic</label>
                                                <input name="product_name_ar" class="form-control" type="text"
                                                       value="{{ old('product_id',$data->product_name_ar) }}"
                                                       placeholder="اسم الصنف بالعربي">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">اسم الصنف بالانجليزي / Product name english</label>
                                                <input name="product_name_en" class="form-control" type="text"
                                                       value="{{ old('product_id',$data->product_name_en) }}"
                                                       placeholder="اسم الصنف بالانجليزي">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">اسم الصنف بالعبرية / Product name hebrew</label>
                                                <input name="product_name_he" class="form-control" type="text"
                                                       value="{{ old('product_id',$data->product_name_he) }}"
                                                       placeholder="اسم الصنف بالعبرية">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">تصنيف المنتج / Category</label>
                                                <select class="form-control select2bs4" style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                        data-select2-id="1" name="category_id" id="">
                                                    @foreach($category as $key)
                                                        <option @if(old('category_id',$data->category_id) == $key->id) selected
                                                                @endif value="{{ $key->id }}">{{ $key->cat_name }}</option>
                                                    @endforeach
                                                </select>
{{--                                                <input type="text" value="@if(!empty($data['category']->cat_name)) {{ $data['category']->cat_name }} @endif" class="form-control">--}}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">اسم الوحدة / Unit</label>
                                                <select class="form-control select2bs4" style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                        data-select2-id="2" name="unit_id" id="">
                                                    @foreach($units as $key)
                                                        <option @if(old('unit_id',$data->unit_id) == $key->id) selected
                                                                @endif value="{{ $key->id }}">{{ $key->unit_name }}</option>
                                                    @endforeach
                                                </select>
{{--                                                <input type="text" value="{{ $data['unit']->unit_name ?? '' }}" class="form-control">--}}
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">الباركود / Barcode</label>
                                                <input name="barcode" class="form-control" type="text"
                                                       value="{{ old('barcode',$data->barcode) }}"
                                                       placeholder="باركود المنتج">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">اقل كمية / Less qty</label>
                                                <input name="less_qty" class="form-control" type="text"
                                                       value="{{ old('less_qty',$data->less_qty) }}"
                                                       placeholder="اقل كمية">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input name="product_status" @if($data->product_status == 1) checked @endif type="checkbox" class="custom-control-input" id="customSwitch3">
                                                    <label class="custom-control-label" for="customSwitch3">حالة المنتج</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">معتمد / غير معتمد</label><br>
                                                <select name="certified" class="form-control w-25 ml-2" style="float: right" id="">
                                                    <option @if($data->certified == 1) selected @endif value="1">معتمد</option>
                                                    <option @if($data->certified == 0) selected @endif value="0">غير معتمد</option>
                                                </select>
                                                <b class="">(معتمد بحاجة الى عرض سعر واحد فقط اما الغير معتمد بحاجة الى 3 عروض اسعار)</b>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">سعر المنتج / Product price</label>
                                                <input class="form-control" name="product_price" type="text"
                                                       value="{{ old('product_price',$data->product_price) }}"
                                                       placeholder="سعر المنتج">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">الوزن (<span class="text-danger">غرام</span>)</label>
                                                <input name="weight" class="form-control" type="text"
                                                       value="{{ old('weight',$data->weight) }}"
                                                       placeholder="الوزن">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">الطول</label>
                                                <input name="height" class="form-control" type="text"
                                                       value="{{ old('height',$data->height) }}"
                                                       placeholder="الطول">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">سعر التكلفة</label>
                                                <input name="cost_price" class="form-control" type="text"
                                                       value="{{ old('cost_price',$data->cost_price) }}"
                                                       placeholder="سعر التكلفة">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">اقل سعر للبيع</label>
                                                <input name="min_sale_price" class="form-control" type="text"
                                                       value="{{ old('min_sale_price',$data->min_sale_price) }}"
                                                       placeholder="اقل سعر للبيع">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">اللون</label>
                                                <input name="color" type="color" value="{{ $data->color }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="assembled_product">هل هذا المنتج مجمع ام لا</label>
                                                <input class="" id="assembled_product" name="assembled_product" type="checkbox"
                                                       value="1"
                                                       {{ $data->assembled_product == 1 ? 'checked' : '' }}
                                                       placeholder="سعر المنتج">
                                            </div>
                                        </div>
                                            <div class="col-md-12 mb-3" id="assembled_form">
                                                <button class="btn btn-success btn-sm mb-2" type="button" onclick="get_data()">add</button>
                                                <select class="form-control select2bs4 " name="" id="select_value">
                                                    @foreach($products as $key)
                                                        <option value="{{ $key->id }}" data-product-name="{{ $key->product_name_ar }}">{{ $key->product_name_ar }}</option>
                                                    @endforeach
                                                </select>
                                                <div id="assembled_product_table">

                                                </div>
{{--                                                <div id="add_input">--}}

{{--                                                </div>--}}
                                                {{--                            <input onchange="" id="assembled_product" type="text">--}}
                                            </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row text-center">
                                        <div class="col-md-12 img-thumbnail mt-5">
                                            <div class="m-2">
                                                    <div class="form-group">
                                                        <label for="">صورة المنتج</label>
                                                        @if (!empty($data->product_photo))
                                                            <button id="delete_button" onclick="delete_image({{ $data->id }})" type="button" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></button>
                                                            <br>
                                                        @endif
                                                        <img width="200px" id="product_image" src="{{ asset('storage/product/'.$data->product_photo) }}" alt="">
                                                        <div class="custom-file mt-2">
                                                            <input name="product_photo" type="file" class="custom-file-input" id="customFile">
                                                            <label class="custom-file-label" for="customFile">اختر ملف</label>
                                                        </div>
                                                    </div>
                                            </div>
                                            <hr>
                                            @if(empty($data->barcode))
                                                لا يوجد باركود للمنتج
                                            @else
                                                <div class="m-2">
                                                    {!! QrCode::size(200)->generate($data->barcode); !!}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <button class="btn btn-success">حفظ البيانات</button>
                            </form>
                        </div>
                        <div class="tab-pane fade @if(Session::has('tab_id')) @if(session('tab_id') == 2) show active @endif @endif" id="custom-tabs-three-product-supplier" role="tabpanel" aria-labelledby="custom-tabs-three-product-supplier-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <p for="" class="text-center">قائمة موردي الصنف</p>
                                    <button class="btn btn-dark btn-sm mb-2" data-toggle="modal" data-target="#modal-lg">اضافة
                                        مورد للصنف
                                    </button>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>اسم المورد</th>
                                            <th>العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['product_supplier'] as $key)
                                            <tr>
                                                <td>{{ $key['user']->name }}</td>
                                                <td>
                                                    <a href="" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                                    <a href="" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade {{ session('tab_id') == 3 ? 'show active' : '' }}" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                            <div class="row">
                                <div class="col-md-3">
                                    <button class="btn btn-dark" data-toggle="modal"  data-target="#product_compatibility">اضافة منتج متوافق</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <table class="table table-sm table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>المنتج</th>
                                                <th>المنتج المتوافق</th>
                                                <th>صورة المنتج</th>
                                                <th>ملاحظات</th>
                                                <th>العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($product_compatibility->isEmpty())
                                                <tr>
                                                    <td colspan="5" class="text-center">لا توجد بيانات</td>
                                                </tr>
                                            @else
                                                @foreach($product_compatibility as $key)
                                                    <tr>
                                                        <td>{{ $key->product->product_name_ar }}</td>
                                                        <td>{{ $key->product_compatibility->product_name_ar }}</td>
                                                        <td>
                                                            <img style="width: 100px" src="{{ asset('storage/product/'.$key->product_image) }}" alt="">
                                                        </td>
                                                        <td>{{ $key->notes }}</td>
                                                        <td>
                                                            <a href="{{ route('product.edit_product_compatibility',['id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade {{ session('tab_id') == 4 ? 'show active' : '' }}" id="custom-tabs-three-assembled-product" role="tabpanel" aria-labelledby="custom-tabs-three-assembled-product-tab">
                            <div class="row">
                                <div class="col-md-3">
                                    <button class="btn btn-dark" data-toggle="modal"  data-target="#assembled_product_modal">الاصناف المجمعة</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div id="list_assembled_product_ajax">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade {{ session('tab_id') == 5 ? 'show active' : '' }}" id="production_lines" role="tabpanel" aria-labelledby="production_lines-tab">
                            <div class="row">
                                <div class="col-md-3">
                                    <button class="btn btn-dark" data-toggle="modal" data-target="#create_production_lines_modal">اضافة خط انتاج</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th style="width: 110px"></th>
                                                <th>اسم خط الانتاج</th>
                                                <th>ملاحظات</th>
                                                <th>عدد المخرجات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if(!$production_lines->isEmpty())
                                            @foreach($production_lines as $key)
                                                <tr>
                                                    <td>
                                                        @if(!empty($key->production_image))
                                                            <img style="width: 80px" src="{{ asset('storage/production/'.$key->production_image) }}" alt="">
                                                        @else
                                                            <img style="width: 80px" src="{{ asset('img/no_img.jpeg') }}" alt="">
                                                        @endif
                                                    </td>
                                                    <td><a href="{{ route('production.production_inputs.index',['id'=>$key->id]) }}">{{ $key->production_name }}</a></td>
                                                    <td>{{ $key->production_notes }}</td>
                                                    <td>{{ $key->production_output_count }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">لا توجد بيانات</td>
                                            </tr>
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

    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('product.createForProductSupplier') }}" method="post">
                @csrf
                <input type="hidden" name="product_id" value="{{ $data->id }}">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة مورد للصنف</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label>يرجى اختيار مورد او شركة</label>
                                <select class="form-control select2bs4" name="user_id" id="">
                                    @foreach($supplier as $key)
                                        <option value="{{ $key->id }}">{{ $key->name }}</option>
                                    @endforeach
                                </select>
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

    <div class="modal fade" id="product_compatibility">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('product.create_product_compatibility') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{ $data->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة منتج متوافق</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>المنتج</label>
                                        <h3 class="alert alert-warning">{{ $data->product_name_ar }}</h3>
                                        {{--                                            <select name="product_id" required class="form-control select2bs4 select2-hidden-accessible"--}}
                                        {{--                                                    style="width: 100%;" data-select2-id="1" tabindex="-1"--}}
                                        {{--                                                    aria-hidden="true">--}}
                                        {{--                                                @foreach($products as $key)--}}
                                        {{--                                                    <option value="{{ $key->id }}">{{ $key->product_name_ar }}</option>--}}
                                        {{--                                                @endforeach--}}
                                        {{--                                            </select>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>اختر الصنف المتوافق</label>
                                        <select name="product_compatibility_id" required class="form-control select2bs4 select2-hidden-accessible"
                                                style="width: 100%;" data-select2-id="1" tabindex="-1"
                                                aria-hidden="true">
                                            @foreach($products as $key)
                                                <option value="{{ $key->id }}">{{ $key->product_name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>اختر الصورة</label>
                                        <input type="file" name="product_image" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>ملاحظات</label>
                                        <textarea name="notes" id="" class="form-control" cols="30" rows="2"></textarea>
                                    </div>
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

    <div class="modal fade" id="assembled_product_modal">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('product.create_assembled_product_ajax') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{ $data->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة منتج مجمع</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" onkeyup="search_assembled_product_ajax('')" id="search_input_assembled_product" placeholder="البحث عن منتج" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div id="search_assembled_product_ajax">

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
    @include('admin.product.modals.create_production_lines')
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

    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    {{--        <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>--}}

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

    <script>
        function delete_image(product_id){
            result = confirm('هل تريد حذف الصورة ؟');
            if(result){
                $.ajax({
                    url: '{{ route('product.delete_image') }}',
                    type: 'post',
                    data:{
                        'product_id': product_id,
                    },
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                    success: function(data) {
                        var image_x = document.getElementById('product_image');
                        image_x.parentNode.removeChild(image_x);

                        document.getElementById('delete_button').remove();
                        // alert(data);
                    },
                    error: function(error) {
                        alert('error')
                    },

                });
            }

        }

        function search_assembled_product_ajax(page){
                $.ajax({
                    url: '{{ route('product.search_assembled_product_ajax') }}',
                    type: 'post',
                    data:{
                        'product_id': {{ $data->id }},
                        'search_input_assembled_product': document.getElementById('search_input_assembled_product').value,
                        'page': page
                    },
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                    success: function(data) {
                        $('#search_assembled_product_ajax').html(data.view);
                    },
                    error: function(error) {
                        alert('error')
                    },
                });
        }

        function create_assembled_product_ajax(assembled_product){
                $.ajax({
                    url: '{{ route('product.create_assembled_product_ajax') }}',
                    type: 'post',
                    data:{
                        'product_id': {{ $data->id }},
                        'assembled_product': assembled_product,
                    },
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                    success: function(data) {
                        search_assembled_product_ajax(page);
                        list_assembled_product_ajax();
                    },
                    error: function(error) {
                        alert('error')
                    },
                });
        }

        function list_assembled_product_ajax(){
                $.ajax({
                    url: '{{ route('product.list_assembled_product_ajax') }}',
                    type: 'post',
                    data:{
                        'product_id': {{ $data->id }},
                    },
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                    success: function(data) {
                        $('#list_assembled_product_ajax').html(data.view);
                    },
                    error: function(error) {
                        alert('error')
                    },
                });
        }

        function delete_assembled_product_ajax(id){
                $.ajax({
                    url: '{{ route('product.delete_assembled_product_ajax') }}',
                    type: 'post',
                    data:{
                        'id': id,
                    },
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                    success: function(data) {
                        toastr.success(data.message);
                        list_assembled_product_ajax();
                        search_assembled_product_ajax(page);
                    },
                    error: function(error) {
                        alert('error')
                    },
                });
        }

        $(document).ready(function() {
            list_assembled_product_ajax();
            search_assembled_product_ajax(page);
            assembled_product_list_for_details_in_product_ajax();
        });
        var page = 1;
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            search_assembled_product_ajax(page);
        });
        var assembledProductData = @json($assembled_product);
        var x = [];
        @if(!$assembled_product->isEmpty())
            @foreach($assembled_product as $key)
        x.push(`
            <input type="hidden" name="assembled_product[]" value="{{ App\Models\ProductModel::where('id',$key->product_id)->first()->id }}">
<input class="form-control" type="text" name="" value="{{ App\Models\ProductModel::where('id',$key->product_id)->first()->product_name_ar }}">
`)
            @endforeach

        @endif
        function add_input() {
            // document.getElementById('add_input').innerHTML('<h1>Mohamad Maraqa</h1>');
            x.push(`<select id="product_att_${x.length}" name="product_att[]" class="form-control">
                @foreach($products as $key)
            <option value="{{ $key->id }}">{{ $key->product_name_ar }}</option>
                @endforeach
            </select>`);

            var empty_string = ``;
            for (var i = 0 ; i < x.length ; i++){
                empty_string = empty_string + x[i];
            }
            $('#add_input').html(empty_string);
        }
        function get_data() {
            var selectedValue = document.getElementById('select_value').value;

            if (selectedValue) {
                // Check if the ID is already present in the array
                var isDuplicate = x.some(function (entry) {
                    return entry.includes(`value="${selectedValue}"`);
                });

                if (!isDuplicate) {
                    var selectedProductName = $('#select_value option:selected').data('product-name');
                    x.push(`
<input type="hidden" name="assembled_product[]" value="${selectedValue}">
<input class="form-control" type="text" name="" value="${selectedProductName}">
`);
                    var empty_string = ``;
                    for (var i = 0; i < x.length; i++) {
                        empty_string = empty_string + x[i];
                    }
                    $('#add_input').html(empty_string);
                } else {
                    // Handle the case when the ID is already present
                    // You can add specific behavior or do nothing depending on your requirements
                    console.log("Duplicate entry, not adding.");
                }
            } else {
                // Handle the case when select_value doesn't have a value
                // You can add specific behavior or do nothing depending on your requirements
                console.log("No value selected.");
            }
        }


        {{--function create_assembled_product_ajax(product_id,assembled_product) {--}}
        {{--    var csrfToken = $('meta[name="csrf-token"]').attr('content');--}}
        {{--    var headers = {--}}
        {{--        "X-CSRF-Token": csrfToken--}}
        {{--    };--}}
        {{--    $.ajax({--}}
        {{--        url: '{{ route('product.create_assembled_product_ajax') }}',--}}
        {{--        method: 'post',--}}
        {{--        headers: headers,--}}
        {{--        data: {--}}
        {{--            'product_id': product_id,--}}
        {{--            'assembled_product': assembled_product--}}
        {{--        },--}}
        {{--        success: function (data) {--}}
        {{--            $('#').html(data.view);--}}
        {{--            toastr.success('تم اضافة البيانات بنجاح')--}}
        {{--        },--}}
        {{--        error: function (jqXHR, textStatus, errorThrown) {--}}
        {{--            alert('error');--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}

        function assembled_product_list_for_details_in_product_ajax(product_id,assembled_product) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('product.assembled_product_list_for_details_in_product_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'product_id': product_id,
                },
                success: function (data) {
                    $('#assembled_product_table').html(data.view);
                    // toastr.success('تم اضافة البيانات بنجاح')
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });
        }

        function assembled_product_create_for_details_in_product_ajax(product_id,assembled_product) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('product.assembled_product_list_for_details_in_product_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'product_id': product_id,
                    'assembled_product': assembled_product
                },
                success: function (data) {
                    $('#assembled_product_table').html(data.view);
                    toastr.success('تم اضافة البيانات بنجاح')
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });
        }

        const checkbox_assembled = document.getElementById('assembled_product');
        checkbox_assembled.addEventListener('click',function handleClick(){
            if(checkbox_assembled.checked){
                document.getElementById('assembled_form').style.display = 'block';
            }
            else{
                document.getElementById('assembled_form').style.display = 'none';
            }
        })

        function f() {

        }

    </script>

    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": true, "autoWidth": true,
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
        $(function () {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $('.swalDefaultSuccess').click(function () {
                Toast.fire({
                    icon: 'success',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultInfo').click(function () {
                Toast.fire({
                    icon: 'info',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultError').click(function () {
                Toast.fire({
                    icon: 'error',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultWarning').click(function () {
                Toast.fire({
                    icon: 'warning',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultQuestion').click(function () {
                Toast.fire({
                    icon: 'question',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });

            $('.toastrDefaultSuccess').click(function () {
                toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultInfo').click(function () {
                toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultError').click(function () {
                toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultWarning').click(function () {
                toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });

            $('.toastsDefaultDefault').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultTopLeft').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    position: 'topLeft',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultBottomRight').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    position: 'bottomRight',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultBottomLeft').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    position: 'bottomLeft',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultAutohide').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    autohide: true,
                    delay: 750,
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultNotFixed').click(function () {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    fixed: false,
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultFull').click(function () {
                $(document).Toasts('create', {
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    icon: 'fas fa-envelope fa-lg',
                })
            });
            $('.toastsDefaultFullImage').click(function () {
                $(document).Toasts('create', {
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    image: '../../dist/img/user3-128x128.jpg',
                    imageAlt: 'User Picture',
                })
            });
            $('.toastsDefaultSuccess').click(function () {
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultInfo').click(function () {
                $(document).Toasts('create', {
                    class: 'bg-info',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultWarning').click(function () {
                $(document).Toasts('create', {
                    class: 'bg-warning',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultDanger').click(function () {
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultMaroon').click(function () {
                $(document).Toasts('create', {
                    class: 'bg-maroon',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
        });

    </script>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({icons: {time: 'far fa-clock'}});

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                {
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function (start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function (event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function () {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function () {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function (file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function () {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function (progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function (file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function (progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function () {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function () {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>

@endsection

