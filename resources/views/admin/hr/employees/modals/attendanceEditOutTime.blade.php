<div class="modal fade" id="attendance_edit_out_time">
    <div class="modal-dialog modal-ml">
        <form action="{{ route('hr.attendance.editOutTime') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="employee_id" value="{{$data->id}}">
            <input type="hidden" name="bfo_attendance_id" id="bfo_attendance_id_attendanceEditOutTimeModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تسجيل  مغادرة الموظف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">نوع الحركة</label>
                                <select class="form-control select2bs4" name="activity_type" id="activity_type">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">تاريخ المغادرة</label>
                                @php
                                    $date = \Carbon\Carbon::now()->toDateString();
                                @endphp
                                <input type="date" name="date" value="{{$date}}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">وقت المغادرة</label>
                                @php
                                    $time = \Carbon\Carbon::now('Asia/Hebron')->toTimeString();
                                @endphp
                                <input type="time" name="time" value="{{$time}}" class="form-control" step="1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">ملاحظات</label>
                                <textarea name="note" id="notes_attendanceEditOutTimeModal" cols="5" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">تسجيل</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
