<div class="modal fade" id="create_vacations_modal">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('users.employees.vacations.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="employee_id" value="{{$data->id}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">إضافة إجازة للموظف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">تاريخ بداية الإجازة</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">تاريخ نهاية الإجازة</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">نوع الإجازة</label>

                                <select class="form-control select2bs4" name="vacations_type_id" id="vacations_type_id_vacationsCreate">
                                    @foreach($vacations_types as $key)
                                    <option value="{{$key->id}}">{{$key->type_name}}</option>
                                    @endforeach
                                </select>
                                <a href="{{route('setting.vacations_types.index')}}" target="_blank">إضافة نوع إجازة جديد</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">الملف المرفق</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="attachement" class="custom-file-input" id="attachement">
                                        <label class="custom-file-label" for="attachement">اختر ملف</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">رفع ملف</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الملاحظات</label>
                                <textarea name="notes" id="" cols="5" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">إضافة إجازة</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
