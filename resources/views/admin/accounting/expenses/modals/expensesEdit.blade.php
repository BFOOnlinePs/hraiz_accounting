<div class="modal fade" id="edit_expenses_modal">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('accounting.expenses.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="expenses_id" id="expenses_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة مصروف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">تاريخ المصروف</label>
                                <input type="date" id="expense_date_edit_expenses" value="{{ date('Y-m-d') }}" name="expense_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">التصنيف</label>
                                <select class="form-control" name="category_id" id="category_id_edit_expenses">
                                    @foreach($expenses_categories as $key)
                                        <option value="{{ $key->id }}">{{ $key->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">القيمة</label>
                                <input type="number" id="amount_edit_expenses" name="amount" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">النص</label>
                                <input type="text" id="title_edit_expenses" name="title" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">المرفق</label>
                                <input type="file" name="files" class="form-control"></div>
                            <div  id="check_attachment">
                                Mohamad Maraqa
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الملاحظات</label>
                                <textarea class="form-control" name="description" id="description_edit_expenses" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="checkbox">التكرار</label>
                                    <input type="checkbox" id="checkbox" onchange="if_checked_for_edit(this.checked)">
                                </div>
                            </div>
                            <div style="display: none" id="recurring_form_edit" class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">التكرار خلال</label>
                                            <input type="text" id="repeat_every_edit_expenses" name="repeat_every" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">خلال</label>
                                            <select class="form-control" name="repeat_type" id="repeat_type_edit_expenses">
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
                                            <input type="text" name="no_of_cycles" id="no_of_cycles_edit_expenses" class="form-control" placeholder="الدورة">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">تعديل مصروف</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
