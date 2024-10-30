@extends('home')
@section('title')
    شكات صادرة
@endsection
@section('header_title')
    شكات صادرة
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    شكات صادرة
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">الزبون</label>
                                <input type="text" onkeyup="list_cheques_ajax()" class="form-control" id="client_name"
                                    name="client_name" placeholder="اسم الزبون">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">نوع الشيك</label>
                                <select onchange="list_cheques_ajax()" name="check_type" id=""
                                    class="form-control">
                                    <option value="">جميع الشيكات</option>
                                    <option value="outgoing">صادر</option>
                                    <option value="incoming">وارد</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">حالة الشيك</label>
                                <select onchange="list_cheques_ajax()" name="check_status" id=""
                                    class="form-control">
                                    <option value="">جميع الشيكات</option>
                                    <option value="paid">مصروف</option>
                                    <option value="under_collection">في التحصيل</option>
                                    <option value="returned">راجع</option>
                                    <option value="portfolio">في المحفظة</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">من تاريخ</label>
                                <input onchange="list_cheques_ajax()" type="date" name="from_date" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">الى تاريخ</label>
                                <input onchange="list_cheques_ajax()" type="date" name="to_date" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div id="list_cheques_ajax">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            list_performance_bond_cheques_ajax();

            $(document).on('click', '#pagination a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                list_performance_bond_cheques_ajax(page);
            });
        });

        function list_performance_bond_cheques_ajax(page = 1) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.bonds.check.list_performance_bond_cheques_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'client_name': $('#client_name').val(),
                    'check_type': $('select[name="check_type"]').val(),
                    'check_status': $('select[name="check_status"]').val(),
                    'from_date': $('input[name="from_date"]').val(),
                    'to_date': $('input[name="to_date"]').val(),
                    'page': page
                },
                success: function(data) {
                    $('#list_cheques_ajax').html(data.view)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_check_status(id, value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.bonds.check.update_check_status_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'check_status': value
                },
                success: function(response) {
                    if (response.success) {
                        $('#check_status_' + id).removeClass('bg-success bg-warning bg-danger bg-info')
                        if (value == 'portfolio') {
                            $('#check_status_' + id).addClass('bg-info')
                        } else if (value == 'paid') {
                            $('#check_status_' + id).addClass('bg-success')
                        } else if (value == 'under_collection') {
                            $('#check_status_' + id).addClass('bg-warning')
                        } else if (value == 'returned') {
                            $('#check_status_' + id).addClass('bg-danger')
                        }
                    }
                    toastr.success(response.message);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_check_type_ajax(id, value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.bonds.check.update_check_type_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'check_type': value
                },
                success: function(response) {
                    toastr.success(response.message);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function update_check_amount_ajax(id, value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.bonds.check.update_check_amount_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'amount': value
                },
                success: function(response) {
                    toastr.success(response.message);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
    </script>

    <script>
        $(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection
