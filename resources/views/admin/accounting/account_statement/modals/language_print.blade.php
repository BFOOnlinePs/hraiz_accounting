<div class="modal fade" id="open_print_modal">
    <div class="modal-dialog modal-xl">
        @csrf
        <form class="modal-content" target="_blank"
            action="{{ route('accounting.account-statement.print_account_statement_details_pdf') }}" method="post">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">اضافة مصروف</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="user_type" value="{{ $user_type }}">
                    <input type="hidden" name="account_statment_type" id="statement_type_print">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>اللغة</label>
                            <select name="language" class="form-control">
                                <option value="ar">العربية</option>
                                <option value="en">الانجليزية</option>
                                <option value="he">العبرية</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-dark">عرض</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
            </div>
        </form>
    </div>
</div>
