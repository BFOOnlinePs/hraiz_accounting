<div class="modal fade" id="edit_salary_modal">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('hr.salaries.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id_salaryEdit">
            <input type="hidden" name="employee_id" value="{{$data->id}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تعديل راتب الموظف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">القيمة</label>
                                <input type="text" value="{{ $data->main_salary ?? 0 }}" name="salary_value" id="salary_value_salaryEdit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">عدد الايام</label>
                                <input type="number" name="days" id="days_salaryEdit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">الشهر</label>
                                <input type="number" id="month_salaryEdit" name="month" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">السنة</label>
                                <input type="number" id="year_salaryEdit" name="year" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-success">تعديل البيانات</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
