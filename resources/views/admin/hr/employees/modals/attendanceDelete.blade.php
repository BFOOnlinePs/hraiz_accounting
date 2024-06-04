<div class="modal fade" id="attendance_delete">
    <div class="modal-dialog modal-ml">
        <form action="{{ route('hr.attendance.delete') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="employee_id" value="{{$data->id}}">
            <input type="hidden" name="bfo_attendance_id" id="bfo_attendance_id_attendanceDeleteModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">هل أنت متأكد من حذف السجل المحدد؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">حذف</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
