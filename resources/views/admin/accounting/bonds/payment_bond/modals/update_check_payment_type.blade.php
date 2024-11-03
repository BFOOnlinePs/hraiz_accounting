<div class="modal fade" id="update_check_payment_type_modal">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('bonds.update_check_information') }}" id="check_create_form" method="post"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="bonds_id" id="bonds_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">معلومات الشيك</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">رقم الشيك</label>
                                <input type="text" name="check_number" id="check_number_edit" class="form-control"
                                    placeholder="رقم الشيك">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">تاريخ الاستحقاق</label>
                                <input type="date" name="due_date" id="due_date_edit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">اسم البنك</label>
                                {{-- <input name="bank_name" id="bank_name_edit" type="text" class="form-control"
                                    placeholder="اسم البنك"> --}}
                                <select name="" id="" class="select2bs4">
                                    @foreach ($banks as $key)
                                        <option id="bank_name_edit" value="{{ $key->id }}">
                                            {{ $key->user_bank_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">حالة الشيك</label>
                                <select name="check_status" class="form-control" id="check_status">
                                    <option value="paid">مصروف</option>
                                    <option value="under_collection">في التحصيل</option>
                                    <option value="returned">راجع</option>
                                    <option value="portfolio">في المحفظة</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-dark">حفظ</button>
                </div>
            </div>
        </form>

    </div>
</div>
