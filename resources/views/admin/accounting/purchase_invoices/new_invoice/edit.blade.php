@extends('home')
@section('title')
    تعديل فاتورة
@endsection
@section('header_title')
    تعديل فاتورة
@endsection
@section('header_link')
    فواتير المشتريات
@endsection
@section('header_title_link')
    تعديل فاتورة
@endsection
@section('style')
@endsection
@section('content')
    @include('admin.messge_alert.success')
    @include('admin.messge_alert.fail')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('accounting.purchase_invoices.update_invoices') }}" method="post">
                @csrf
                <input type="hidden" value="{{ $data->id }}" name="id">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">تاريخ الفاتورة</label>
                            <input required type="date" name="bill_date" class="form-control text-center" value="{{ $data->bill_date }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">تاريخ التسليم</label>
                            <input required type="date" value="{{ $data->due_date }}" name="due_date" class="form-control text-center">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">الرقم المرجعي</label>
                            <input required type="text" class="form-control" value="{{ $data->invoice_reference_number }}" name="invoice_reference_number">
                        </div>
                    </div>
                    {{-- <div hidden class="col-md-12">
                        <div class="form-group">
                            <label for="">المشروع</label>
                            <input type="text" name="project_id" class="form-control">
                        </div>
                    </div> --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">العميل</label>
                            <select required class="form-control" name="client_id" id="">
                                <option value="">اختر عميل</option>
                                @foreach ($client as $key)
                                    <option @if($key->id == $data->user->id) selected @endif value="{{ $key->id }}">{{ $key->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">الضريبة الاولى</label>
                            <input required type="text" name="tax_id" value="{{ $data->tax_id }}" class="form-control" placeholder="الضريبة الاولى">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">الضريبة الثانية</label>
                            <input type="text" name="tax_id2" value="{{ $data->tax_id2 }}" class="form-control" placeholder="الضريبة الثانية">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="checkbox">التكرار</label>
                            <input type="checkbox" id="checkbox" onchange="if_checked(this.value)">
                        </div>
                    </div>
                    <div style="display: none" id="recurring_form" class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">التكرار خلال</label>
                                    <input type="text" value="{{ $data->repeat_every }}" name="repeat_every" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">خلال</label>
                                    <select class="form-control" name="repeat_type" id="">
                                        <option @if($data->repeat_type == 'days') selected @endif value="days">يوم</option>
                                        <option @if($data->repeat_type == 'week') selected @endif value="week">اسبوع</option>
                                        <option @if($data->repeat_type == 'month') selected @endif value="month">شهر</option>
                                        <option @if($data->repeat_type == 'year') selected @endif value="year">سنة</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">الدورة</label>
                                    <input type="text" value="{{ $data->no_of_cycles }}" name="no_of_cycles" class="form-control" placeholder="الدورة">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">ملاحظات</label>
                            <textarea class="form-control" name="note" id="" cols="30" rows="3">{{ $data->note }}</textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">تعديل البيانات</button>
            </form>
        </div>

    </div>
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('accounting.texes.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة ضريبة</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">اسم الضريبة</label>
                                    <input required type="text" class="form-control" name="tax_name"
                                        placeholder="اسم الضريبة">
                                </div>
                                <div class="form-group">
                                    <label for="">نسبة الضريبة</label>
                                    <input required type="text" class="form-control" name="tax_ratio"
                                        placeholder="نسبة الضريبة">
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
    <script>
        function if_checked() {
            var checkbox = document.getElementById("checkbox");
            var recurring_form = document.getElementById("recurring_form");

            if (checkbox.checked == true) {
                recurring_form.style.display = "block";
            } else {
                recurring_form.style.display = "none";
            }
        }
    </script>
@endsection
