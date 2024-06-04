<div class="modal fade" id="create_bonuses_modal">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('users.employees.bonuses.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="employee_id" value="{{$data->id}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">إضافة علاوة للموظف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">القيمة</label>
                                <input type="number" step="any" name="value" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">نوع العلاوة</label>
                                <select class="form-control select2bs4" name="type">
                                    <option value="0">نسبة</option>
                                    <option value="1">عدد (مبلغ محدد)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الملاحظات</label>
                                <textarea name="notes" id="" cols="5" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">إضافة علاوة</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
