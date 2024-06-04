<div class="modal fade" id="edit_attendance">
    <div class="modal-dialog modal-ml">
        <form action="{{ route('hr.attendance.edit') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="employee_id" value="{{$data->id}}">
            <input type="hidden" name="bfo_attendance_id" id="bfo_attendance_id_attendanceEdit">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تعديل سجل الحضور والمغادرة للموظف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">نوع الحركة</label>
                                <select class="form-control select2bs4" name="activity_type" id="activity_type_edit_modal">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">تاريخ الحضور</label>
                                <input type="date" name="in_time_date" class="form-control" id="in_time_date_edit_modal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">وقت الحضور</label>
                                <input type="time" name="in_time_time" class="form-control" id="in_time_time_edit_modal" step="1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">تاريخ المغادرة</label>
                                <input type="date" name="out_time_date" class="form-control" id="out_time_date_edit_modal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">وقت المغادرة</label>
                                <input type="time" name="out_time_time" class="form-control" id="out_time_time_edit_modal" step="1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">ملاحظات</label>
                                <textarea name="note" cols="5" rows="2" class="form-control" id="notes_edit_modal"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">تعديل</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
