@extends('home')
@section('title')
    المصروفات
@endsection
@section('header_title')
    قائمة المصروفات
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    قائمة المصروفات
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-dark" data-toggle="modal"
                    data-target="#create_expenses_modal">اضافة مصروف
            </button>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">القسم</label>
                                <select onchange="expenses_table_ajax()" class="form-control" name="" id="category_id">
                                    <option value="">جميع الاقسام</option>
                                    @foreach($expenses_categories as $key)
                                        <option value="{{ $key->id }}">{{ $key->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">اضافة بواسطة</label>
                                <select onchange="expenses_table_ajax()" class="form-control" name="" id="added_by">
                                    <option value="">جميع المستخدمين</option>
                                    @foreach($users as $key)
                                        <option value="{{ $key->id }}">{{ $key->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">من</label>
                                <input onchange="expenses_table_ajax()" value="{{ $start_date }}" id="from" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">الى</label>
                                <input onchange="expenses_table_ajax()" value="{{ $end_date }}" id="to" type="date" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="expenses_table">

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.accounting.expenses.modals.expensesCreate')
    @include('admin.accounting.expenses.modals.expensesEdit')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>

        $(document).ready(function () {
            expenses_table_ajax();
        });

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
            $('#category_id_edit_expenses').val(data.category_id);

            $('#edit_expenses_modal').modal('show');
        }

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

        function expenses_table_ajax() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('accounting.expenses.expenses_table_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'category_id':$('#category_id').val(),
                    'added_by':$('#added_by').val(),
                    'from':$('#from').val(),
                    'to':$('#to').val()
                },
                success: function (data) {
                    $('#expenses_table').html(data.view);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                }
            });
        }
    </script>

    <script>
        $(function(){
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection

