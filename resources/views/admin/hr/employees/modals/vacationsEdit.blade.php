<div class="modal fade" id="edit_vacations_modal">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('users.employees.vacations.edit') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id_vacationsEdit">
            <input type="hidden" name="employee_id" value="{{$data->id}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تعديل إجازة للموظف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">تاريخ الإجازة</label>
                                <input type="date" name="v_date" id="v_date_vacationsEdit" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">نوع الإجازة</label>
                                <select class="form-control select2bs4" name="vacations_type_id" id="vacations_type_id_vacationsEdit">

                                </select>
                                <a href="{{route('setting.vacations_types.index')}}" target="_blank">إضافة نوع إجازة جديد</a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الملاحظات</label>
                                <textarea name="notes" id="notes_vacationsEdit" cols="5" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">الملف المرفق</label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <a id="attachement_vacationsEdit" target="_blank">تحميل الملف المرفق مسبقًا</a>
                                    </div>
                                    <div class="input-group-append">
                                        <div class="custom-file">
                                            <input type="file" name="attachement" class="custom-file-input" id="attachement_vacations_type_id">
                                            <label class="custom-file-label" for="attachement">اختر ملف</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">رفع ملف</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">تعديل الإجازة</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
