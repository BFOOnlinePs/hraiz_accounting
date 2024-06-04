<div class="modal fade" id="create_production_order_modal">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('production.production_inputs.create_production_orders') }}" method="post" enctype="multipart/form-data">
            @csrf
{{--            <input type="text" name="production_line_id" value="{{ $production_lines->id }}">--}}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة امر للانتاج</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">اختر خط انتاج</label>
                                <select required class="form-control" name="production_line_id" id="">
                                    <option value="">اختر خط الانتاج ...</option>
                                    @foreach($production_lines as $key)
                                        <option value="{{ $key->id }}">{{ $key->production_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">اسم الموظف</label>
                                <select class="form-control" name="employee_id" id="">
                                    @foreach($employees as $key)
                                        <option value="{{ $key->id }}">{{ $key->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="images" class="col-md-6">
                            <div class="form-group">
                                <label for="">تاريخ التسليم</label>
                                <input class="form-control text-center" name="submission_date" value="@php echo date('Y-m-d') @endphp" type="date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">الكمية</label>
                                <input type="text" class="form-control" name="qty" placeholder="الكمية">
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
