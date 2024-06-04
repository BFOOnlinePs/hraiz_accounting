<div class="modal fade" id="create_salary_modal">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('hr.salaries.create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_rewardEdit" id="id_rewardEdit">
            <input type="hidden" name="employee_id" value="{{$data->id}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة راتب</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">القيمة</label>
                                <input type="text" value="{{ $data->main_salary ?? 0 }}" name="salary_value" id="value_rewardEdit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">عدد الايام</label>
                                <input type="number" name="days" id="value_rewardEdit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">الشهر</label>
                                <select class="form-control" name="month" id="">
                                    @for($i = 1;$i<=12;$i++)
                                        <option @if(\Carbon\Carbon::now()->format('m') == $i) selected @endif value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
{{--                                <input type="number" value="{{ \Carbon\Carbon::now()->format('m') }}" name="month" class="form-control">--}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">السنة</label>
                                <input type="number" value="{{ \Carbon\Carbon::now()->format('Y') }}" name="year" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-dark">اضافة الراتب</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
