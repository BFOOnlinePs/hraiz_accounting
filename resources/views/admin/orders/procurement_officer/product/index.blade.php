@extends('home')
@section('title')
    طلبات الشراء
@endsection
@section('header_title')
    طلب شراء <span>
        @if ($order->reference_number != 0)
            #{{ $order->reference_number }}
        @endif
    </span>
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    طلبات الشراء
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
        .active {
            color: black !important;
        }

        .nav-link {
            text-decoration: none;
        }

        .mt-100 {
            margin-top: 150px;
            margin-left: 200px
        }

        /*.card-header {*/
        /*    background-color: #9575CD*/
        /*}*/
        h5 {
            color: #fff
        }

        .card-block {
            margin-top: 10px
        }

        .mytooltip {
            display: inline;
            position: absolute;
            z-index: 999
        }

        .mytooltip .tooltip-item {
            background: rgba(0, 0, 0, 0.1);
            cursor: pointer;
            display: inline-block;
            font-weight: 500;
            padding: 0 10px
        }

        .mytooltip .tooltip-content {
            position: absolute;
            z-index: 9999;
            width: 500px;
            right: 40px;
            /*left: 50%;*/
            margin: 0 0 -40px -180px;
            bottom: 100%;
            text-align: left;
            font-size: 14px;
            line-height: 30px;
            -webkit-box-shadow: -5px -5px 15px rgba(48, 54, 61, 0.2);
            box-shadow: -5px -5px 15px rgba(48, 54, 61, 0.2);
            background: #2b2b2b;
            opacity: 0;
            cursor: default;
            pointer-events: none
        }

        .mytooltip .tooltip-content::after {
            content: '';
            top: 100%;
            right: 0px;
            border: solid transparent;
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-color: #2a3035 transparent transparent;
            border-width: 10px;
            margin-left: -10px
        }

        .mytooltip .tooltip-content img {
            position: relative;
            width: 100%;
            display: block;
            float: left;
            margin-right: 1em
        }

        .mytooltip .tooltip-item::after {
            content: '';
            position: absolute;
            width: 360px;
            height: 20px;
            bottom: 100%;
            left: 50%;
            pointer-events: none;
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%)
        }

        .mytooltip:hover .tooltip-item::after {
            pointer-events: auto
        }

        .mytooltip:hover .tooltip-content {
            pointer-events: auto;
            opacity: 1;
            -webkit-transform: translate3d(0, 0, 0) rotate3d(0, 0, 0, 0deg);
            transform: translate3d(0, 0, 0) rotate3d(0, 0, 0, 0deg)
        }

        .mytooltip:hover .tooltip-content2 {
            opacity: 1;
            font-size: 18px
        }

        .mytooltip .tooltip-text {
            font-size: 14px;
            line-height: 24px;
            display: block;
            padding: 1.31em 1.21em 1.21em 0;
            color: #fff
        }
    </style>

    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
@endsection
@section('content')

    {{--    @include('admin.orders.progreesbar') --}}
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    @include('admin.orders.order_menu')
    <div class="card">
        <div class="card-header">
            <h4 class="text-center">الاصناف <a target="_blank"
                    href="{{ route('procurement_officer.orders.product.product_list_pdf', ['order_id' => $order->id]) }}"><span
                        style="float: left;font-size:20px" class="fa fa-download btn btn-dark"></span></a></h4>
        </div>
        <div class="card-body">
            <div class="row p-2">
                <div class="col-md-12">
                    <button type="button" data-bs-target="#staticBackdrop" class="btn btn-dark mb-2" data-toggle="modal"
                        data-target="#modal-lg-product">اضافة صنف
                    </button>
                    <div id="order_items_table">

                    </div>
                    {{-- <div class="table-responsive">
                        <table class="table table-hover border">
                            <thead>
                                <tr>
                                    <th>الرقم</th>
                                    <th>الصورة</th>
                                    <th>اسم الصنف</th>
                                    <th>اسم الصنف انجليزي</th>
                                    <th>الكمية</th>
                                    <th>الوحدة</th>
                                    @if ($order->order_status == 0)
                                        <th>العمليات</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center"> لا توجد بيانات</td>
                                    </tr>
                                @else
                                    @foreach ($data as $key)
                                        <tr id="delete_tr_{{ $loop->index }}">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <span class="mytooltip tooltip-effect-1">
                                                    <span class="tooltip-item"
                                                        style='width: 65px;height: 50px;background-image: url("{{ asset('storage/product/' . $key['product']->product_photo) }}");background-size: contain;background-repeat: no-repeat;background-position: center'>

                                                    </span>
                                                    <span class="tooltip-content clearfix">
                                                        <img
                                                            src="{{ asset('storage/product/' . $key['product']->product_photo) }}">
                                                    </span>
                                                </span>
                                            </td>
                                            <td>
                                                @if (!empty($key['product']->product_name_ar))
                                                    {{ $key['product']->product_name_ar }}
                                                @endif
                                            </td>
                                            <td>
                                                <input onchange="edit_product_ajax({{ $key['product']->id }})"
                                                    id="product_name_en_{{ $key['product']->id }}" class="form-control"
                                                    type="text" value="{{ $key['product']->product_name_en }}">
                                            </td>
                                            <td>
                                                <input onchange="updateQty( this.value  , {{ $key->id }})"
                                                    id="qty_{{ $loop->index }}" style="width: 80%" class="form-control"
                                                    type="number" value="{{ $key->qty }}" placeholder="ادخل الكمية">
                                            </td>
                                            <td style="width: 150px">
                                                <select onchange="updateUnit(this.value  , {{ $key->id }})"
                                                    name="product_id"
                                                    class="form-control select2bs4 select2-hidden-accessible"
                                                    style="width: 80%;" data-select2-id="{{ $loop->index }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    @foreach ($unit as $unit_key)
                                                        <option @if (old(
                                                                'unit_id',
                                                                App\Models\OrderItemsModel::where('order_id', $order->id)->where('product_id', $key['product']->id)->value('unit_id')) == $unit_key->id) selected @endif
                                                            value="{{ $unit_key->id }}">{{ $unit_key->unit_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="deleteItems({{ $key->id }} , {{ $loop->index }})">
                                                    <span class="fa fa-trash"></span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div> --}}
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal-lg-product">
        <div class="modal-dialog ">
            {{-- <form action="{{ route('procurement_officer.orders.create_order_items') }}" method="POST">
                @csrf --}}
                <input type="hidden" id="order_id" value="{{ $order->id }}" name="order_id">
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <h4 class="modal-title">اضافة اصناف الى الطلبية</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" onkeyup="search_product(this.value)" class="form-control"
                            placeholder="البحث عن صنف">
                        <div class="row mt-2">
                            <div class="col-md-12" id="search_product_view">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                        <button class="btn btn-dark">حفظ البيانات</button>
                    </div>
                </div>
            {{-- </form> --}}
        </div>
    </div>
    <div class="text-center">
        <p>تم انشاء هذه الطلبية بواسطة <span class="text-danger text-bold">{{ $order['user']->name ?? '' }}</span> ويتم
            متابعتها بواسطة <span class="text-danger text-bold">{{ $order['to_user']->name ?? '' }}</span></p>
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
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>

    <script>
        function updateQty(qty, order_items_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ url('orders/updateQtyForOrder_items') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': {{ $order->id }},
                    'order_items_id': order_items_id,
                    'qty': qty
                },
                success: function(data) {
                    toastr.success('تم تعديل الكمية بنجاح')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function updateUnit(unit_id, order_items_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ url('orders/updateUnitOrder_items') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id': {{ $order->id }},
                    'order_items_id': order_items_id,
                    'unit_id': unit_id
                },
                success: function(data) {
                    toastr.success('تم تعديل الوحدة بنجاح')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function deleteItems(order_items_id, index) {
            if (confirm('هل انت متاكد من عملية الحذف ؟')) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '{{ url('orders/deleteItems') }}' + '/' + order_items_id,
                    method: 'get',
                    headers: headers,
                    success: function(data) {
                        document.getElementById('delete_tr_' + index).remove();
                        toastr.success('تم الحذف بنجاح');
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });
            }

        }

        var products = {!! json_encode($product) !!};
        var units = {!! json_encode($unit) !!};

        function selectedUnit(product_id) {
            var selectedProduct = products.find(function(product) {
                return product.id == product_id;
            });

            if (selectedProduct) {
                // Get the unit_id linked to the selected product
                var selectedUnitId = selectedProduct.unit_id;

                // Populate the "Units" select with all units
                var unitsSelect = $('#units');
                unitsSelect.empty(); // Clear previous options

                // Add the default option
                unitsSelect.append($('<option>', {
                    value: '',
                    text: 'اختر وحدة',
                    selected: true
                }));

                // Add the options for each unit
                units.forEach(function(unit) {
                    unitsSelect.append($('<option>', {
                        value: unit.id,
                        text: unit.unit_name,
                        selected: unit.id ==
                            selectedUnitId // Select the unit linked to the selected product
                    }));
                });

                // Refresh the select2 plugin (if you are using it)
                unitsSelect.trigger('change');
            }
        }

        function edit_product_ajax(id) {

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('product.edit_product_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'product_id': id,
                    'product_name_en': document.getElementById('product_name_en_' + id).value,
                },
                success: function(data) {
                    console.log(data);
                    toastr.success('تم تعديل الاسم بنجاح')
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }

            });

        }

        // Update your AJAX call to include checkbox states
        function search_product(search_product, page = 1) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };

            $.ajax({
                url: '{{ route('procurement_officer.orders.product.search_product_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'search_product': search_product,
                    'order_id': {{ $order->id }},
                    'page': page,
                },
                success: function(data) {
                    $('#search_product_view').html(data.view);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function create_product_ajax(product_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('procurement_officer.orders.product.create_product_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id' : document.getElementById('order_id').value,
                    'product_id' : product_id,
                    'unit_id' : document.getElementById('unit_id_'+product_id).value
                },
                success: function(data) {
                    console.log(data);
                    toastr.success('تمت الاضافة الاسم بنجاح')
                    order_items_table();
                    search_product('',page)
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }

            });
        }

        function order_items_table() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            document.getElementById('order_items_table').innerHTML = '<div class="col text-center p-5"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';
            $.ajax({
                url: '{{ route('procurement_officer.orders.product.order_items_table') }}',
                method: 'post',
                headers: headers,
                data: {
                    'order_id' : document.getElementById('order_id').value,
                },
                success: function(data) {
                    // console.log(data);
                    $('#order_items_table').html(data.view);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }

            });
        }

        var page = 1;

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];

            search_product('', page, checkboxStates);
        });


        $(document).ready(function() {
            search_product();
            order_items_table();
        });
    </script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
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
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $('.swalDefaultSuccess').click(function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultInfo').click(function() {
                Toast.fire({
                    icon: 'info',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultError').click(function() {
                Toast.fire({
                    icon: 'error',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultWarning').click(function() {
                Toast.fire({
                    icon: 'warning',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultQuestion').click(function() {
                Toast.fire({
                    icon: 'question',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });

            $('.toastrDefaultSuccess').click(function() {
                toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultInfo').click(function() {
                toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultError').click(function() {
                toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultWarning').click(function() {
                toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });

            $('.toastsDefaultDefault').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultTopLeft').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    position: 'topLeft',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultBottomRight').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    position: 'bottomRight',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultBottomLeft').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    position: 'bottomLeft',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultAutohide').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    autohide: true,
                    delay: 750,
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultNotFixed').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title',
                    fixed: false,
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultFull').click(function() {
                $(document).Toasts('create', {
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    icon: 'fas fa-envelope fa-lg',
                })
            });
            $('.toastsDefaultFullImage').click(function() {
                $(document).Toasts('create', {
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    image: '../../dist/img/user3-128x128.jpg',
                    imageAlt: 'User Picture',
                })
            });
            $('.toastsDefaultSuccess').click(function() {
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultInfo').click(function() {
                $(document).Toasts('create', {
                    class: 'bg-info',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultWarning').click(function() {
                $(document).Toasts('create', {
                    class: 'bg-warning',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultDanger').click(function() {
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Toast Title',
                    subtitle: 'Subtitle',
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultMaroon').click(function() {
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
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

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
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                        'MMMM D, YYYY'))
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

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
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

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>
@endsection
