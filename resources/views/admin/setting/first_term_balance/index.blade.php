@extends('home')
@section('title')
    رصيد اول المدة
@endsection
@section('header_title')
    رصيد اول المدة
@endsection
@section('header_link')
    الاعدادات
@endsection
@section('header_title_link')
    رصيد اول المدة
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-4">
                                <div class="form-group">

                                </div>
                                <input class="form-control" type="text" readonly value="{{ session()->get('login_date') }}">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button class="btn btn-dark">ترحيل جميع الارصدة</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <div id="first_term_balance_table">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            first_term_balance_table_ajax();
        })
        function first_term_balance_table_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('setting.first_term_balance.first_term_balance_table_ajax') }}',
                method: 'post',
                headers: headers,
                data: {

                },
                success: function(data) {
                    $('#first_term_balance_table').html(data.view);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }

        function updateFirstTermBalance(value,client_id,currency_id) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('setting.first_term_balance.update_first_term_balance_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'value': value,
                    'client_id': client_id,
                    currency_id: currency_id
                },
                success: function(data) {

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error');
                }
            });
        }
    </script>
@endsection
