<div class="modal fade" id="add_registration_modal">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('accounting.bonds.registration_bonds.create_registration_bonds') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة سند قيد</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">المورد او العميل</label>
                                <select required name="client_id" id="" class="form-control select2bs4">
                                    <option value="">اختر مورد او عميل ...</option>
                                    @foreach($client as $key)
                                        <option value="{{ $key->id }}">{{ $key->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">نوع السند</label>
                                <select required name="debt_credit" id="" class="form-control select2bs4">
                                    <option value="credit">دائن</option>
                                    <option value="debt">مدين</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">العملة</label>
                                <select required name="currency_id" id="" class="form-control select2bs4">
                                    <option value="credit">اختر العملة</option>
                                    @foreach($currency as $key)
                                        <option value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input required id="invoice_amount" type="text" name="amount" class="form-control text-center" style="background-color: palegoldenrod;font-size: 50px;height: 80px !important;vertical-align: middle;padding-top: 25px" pattern="[0-9]+" title="يجب ادخال ارقام فقط" placeholder="قيمة سند الصرف">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الوصف</label>
                                <textarea name="notes" class="form-control" id="" cols="30" rows="2" placeholder="الوصف"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" value="cash" id="cash_for_client" name="customRadio" checked="">
                                            <label for="cash_for_client" class="custom-control-label">كاش</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" value="check" id="check_for_client" name="customRadio">
                                            <label for="check_for_client" class="custom-control-label">شيك</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="display: none" id="check_information_client">
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
