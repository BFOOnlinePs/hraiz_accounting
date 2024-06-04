<div class="modal fade" id="editVacationsTypesModal">
    <div class="modal-dialog">
        <form action="{{ route('setting.vacations_types.edit') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="id_editVacationsTypesModal" name="id">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تعديل نوع الإجازة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">نوع الإجازة</label>
                        <input name="type_name" class="form-control" type="text" id="type_name_editVacationsTypesModal" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>

            </div>
        </form>

    </div>
</div>
