<div class="modal fade" id="edit-attendance-device-modal">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('setting.system_setting.update_time_attendance_device_option') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" name="id" id="attendance_device_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة ساعة جديدة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Ip</label>
                                <input name="ip" id="ip_input" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Port</label>
                                <input name="port" id="port_input" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">User name</label>
                                <input name="user_name" id="user_name_input" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Password</label>
                                <input name="password" id="password_input" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Status right</label>
                                <input name="status_right" id="status_right" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Status left</label>
                                <input name="status_left" id="status_left" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Status up</label>
                                <input name="status_up" id="status_up" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Status down</label>
                                <input name="status_down" id="status_down" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>

            </div>
        </form>

    </div>
</div>
