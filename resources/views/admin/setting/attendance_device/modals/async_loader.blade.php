<div class="modal fade" id="async-loader-modal" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form style="width: 100%" action="{{ route('setting.attendance_device.update_time_attendance_device_option') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row text-center">
                        <div class="col-md-12" id="async_loader_col">

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
