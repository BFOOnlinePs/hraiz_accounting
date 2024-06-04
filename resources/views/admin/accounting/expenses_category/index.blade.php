@extends('home')
@section('title')
    تصنيف المصروفات
@endsection
@section('header_title')
    تصنيف المصروفات
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    تصنيف المصروفات
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
                    data-target="#expenses-category-create-modal">اضافة تصنيف للمصروف
            </button>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-bordered table-sm">
                        <thead>
                        <tr>
                            <th>الاسم</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($data->isEmpty())
                            <tr>
                                <td colspan="2" class="text-center">لا توجد بيانات</td>
                            </tr>
                        @else
                            @foreach($data as $key)
                                <tr>
                                    <td>{{ $key->title }}</td>
                                    <td>
                                        <button type="button" onclick="get_expenses_category_data({{ $key }})"
                                                class="btn btn-success btn-sm"><span
                                                class="fa fa-edit"></span></button>
{{--                                        <a onclick="return confirm('هل انت متاكد من حذف البيانات ؟')" href="{{ route('accounting.expenses.delete',['id'=>$key->id]) }}" class="btn btn-danger btn-sm"><span--}}
{{--                                                class="fa fa-trash"></span></a>--}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.accounting.expenses_category.modals.expensesCategoryCreate')
    @include('admin.accounting.expenses_category.modals.expensesCategoryEdit')
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        function get_expenses_category_data(data) {
            $('#expenses_category_id').val(data.id);
            $('#title').val(data.title);
            $('#expenses-category-edit-modal').modal('show');
        }
    </script>
@endsection

