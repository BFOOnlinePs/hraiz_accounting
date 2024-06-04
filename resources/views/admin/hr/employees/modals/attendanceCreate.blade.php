<div class="modal fade" id="attendance_in_time">
    <div class="modal-dialog modal-ml">
        <form action="{{ route('hr.attendance.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="employee_id" value="{{$data->id}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تسجيل حضور الموظف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">نوع الحركة</label>
                                <select class="form-control select2bs4" name="activity_type">
                                    <option value="دوام">دوام</option>
                                    <option value="خاص">خاص</option>
                                    <option value="ميداني">ميداني</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">تاريخ الحضور</label>
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
                                <label for="">وقت الحضور</label>
                                @php
                                    $time = \Carbon\Carbon::now('Asia/Hebron')->toTimeString();
                                @endphp
                                <input type="time" name="time" value="{{$time}}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">ملاحظات</label>
                                <textarea name="note" cols="5" rows="2" class="form-control"></textarea>
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
