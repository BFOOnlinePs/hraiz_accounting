<div class="modal fade" id="create_payment_bond_modal">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('accounting.bonds.performance_bond.performance_bond_create') }}" method="post" id="bonds_create" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="invoice_modal_type" value="invoice">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة سند صرف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">اختر فاتورة</label>
                                <select onchange="get_amount_for_invoice()" required class="form-control select2bs4" name="invoice_id" id="invoice_select">
                                    <option value="">اختر فاتورة ...</option>
                                    @foreach($invoices as $key)
                                        <option value="{{ $key->id }}">{{ $key->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">الرقم المرجعي</label>
                                <input type="text" name="reference_number" class="form-control" placeholder="الرقم المرجعي">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">العملة</label>
                                <select class="form-control select2bs4" required name="currency_id" id="">
                                    <option value="">اختر العملة ...</option>
                                    @foreach($currencies as $key)
                                        <option value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">القيمة</label>
                                <input required id="invoice_amount" type="text" name="amount" class="form-control text-center" pattern="[0-9]+" title="يجب ادخال ارقام فقط" style="background-color: palegoldenrod;font-size: 50px;height: 80px !important;vertical-align: middle;padding-top: 25px" placeholder="قيمة سند الصرف">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">الملاحظات</label>
                                <textarea class="form-control" name="notes" id="" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="cash" id="cash" name="customRadio" checked="">
                                <label for="cash" class="custom-control-label">كاش</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" value="check" id="check" name="customRadio">
                                <label for="check" class="custom-control-label">شيك</label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display: none" id="check_information">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="checkNumber">رقم الشيك</label>
                                <input name="check_number" type="text" class="form-control" id="checkNumber" placeholder="رقم الشيك" pattern="[0-9]+" title="يرجى إدخال رقم شيك صحيح (الأرقام فقط)">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">تاريخ الاستحقاق</label>
                                <input name="due_date" id="due_date" type="date" class="form-control" placeholder="تاريخ الاستحقاق">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">اسم البنك</label>
                                <input name="bank_name" id="bank_name" type="text" class="form-control" placeholder="اسم البنك">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">حالة الشيك</label>
                                <select class="form-control" name="check_status" id="check_status_for_client">
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
                    <button type="submit" class="btn btn-dark">اضافة البيانات</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
