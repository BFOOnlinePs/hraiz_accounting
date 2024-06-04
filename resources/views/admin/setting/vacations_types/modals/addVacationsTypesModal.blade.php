<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <form action="{{ route('setting.vacations_types.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">إضافة نوع إجازة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">نوع الإجازة</label>
                        <input name="type_name" class="form-control" type="text" required>
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
