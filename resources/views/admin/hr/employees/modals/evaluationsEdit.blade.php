<div class="modal fade" id="edit_evaluations_modal">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('users.employees.evaluations.edit') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id_evaluationsEdit">
            <input type="hidden" name="employee_id" value="{{$data->id}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تعديل تقييم للموظف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الملاحظات</label>
                                <textarea name="notes" id="notes_evaluationsEdit" cols="5" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الملف المرفق</label>
                                <div class="input-group-append">
                                    <a id="attachment_evaluationsEdit" target="_blank">تحميل الملف المرفق مسبقًا</a>
                                </div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="attachment" class="custom-file-input">
                                        <label class="custom-file-label" for="attachment">اختر ملف</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">رفع ملف</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">تعديل تقييم</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
