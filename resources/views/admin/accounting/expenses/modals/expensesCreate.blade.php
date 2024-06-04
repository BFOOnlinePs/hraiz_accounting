<div class="modal fade" id="create_expenses_modal">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('accounting.expenses.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة مصروف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="">تاريخ المصروف</label>
                                        <input required type="date" value="{{ date('Y-m-d') }}" name="expense_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">العملة</label>
                                        <select required class="form-control" name="currency_id" id="">
                                            <option value="">اختر العملة</option>
                                            @foreach($currencies as $key)
                                                <option value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">المبلغ</label>
                                        <input required placeholder="ادخل مبلغ" type="text" style="background-color: palegoldenrod;font-size: 50px;height: 80px !important;vertical-align: middle;padding-top: 25px" name="amount" class="form-control text-center">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">وذلك عن</label>
                                        <textarea required name="title" class="form-control" id="" style="background-color: palegoldenrod;" cols="30" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">التصنيف</label>
                                        <select required class="form-control" name="category_id" id="">
                                            <option value="">اختر تصنيف ...</option>
                                            @foreach($expenses_categories as $key)
                                                <option value="{{ $key->id }}">{{ $key->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">المرفق</label>
                                        <input type="file" name="files" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">الملاحظات</label>
                                        <textarea class="form-control" name="description" id="" cols="30" rows="2"></textarea>
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">التكرار خلال</label>
                                                <input type="text" name="repeat_every" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">خلال</label>
                                                <select class="form-control" name="repeat_type" id="">
                                                    <option value="days">يوم</option>
                                                    <option value="weeks">اسبوع</option>
                                                    <option value="months">شهر</option>
                                                    <option value="years">سنة</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">الدورة</label>
                                                <input type="text" id="no_of_cycles" name="no_of_cycles" class="form-control" placeholder="الدورة">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-dark">إضافة مصروف</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
