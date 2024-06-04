@extends('home')
@section('title')
    تعديل اوامر الانتاج
@endsection
@section('header_title')
    تعديل اوامر الانتاج
@endsection
@section('header_link')
    خطوط الانتاج الانتاج
@endsection
@section('header_title_link')
    تعديل اوامر الانتاج
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')

    <div class="card">
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <form action="{{ route('production.production_inputs.update_production_orders') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $data->id }}" name="id">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">رقم الموظف</label>
                                <select class="form-control" name="employee_id" id="">
                                    @foreach($employees as $key)
                                        <option value="{{ $key->id }}">{{ $key->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">حالة الامر</label>
                                <select class="form-control" name="status" id="">
                                    <option @if($data->status == 'new') selected @endif value="new">new</option>
                                    <option @if($data->status == 'process') selected @endif value="process">process</option>
                                    <option @if($data->status == 'complete') selected @endif value="complete">complete</option>
                                </select>
                            </div>
                        </div>
{{--                        <div class="col-sm-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="">تاريخ الاضافة</label>--}}
{{--                                <input type="datetime-local" value="{{ $data->insert_at }}" class="form-control">--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">تاريخ التسليم</label>
                                <input type="date" value="{{ $data->submission_date }}" name="submission_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">ملاحظات</label>
                                <textarea class="form-control" name="note" id="" cols="30" rows="3">{{ $data->note }}</textarea>
                            </div>
                        </div>
                        <button class="btn btn-success">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection()

@section('script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection

