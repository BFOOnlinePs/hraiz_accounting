<div class="modal fade" id="create_payment_bond_modal">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <input type="hidden" name="invoice_modal_type" value="client">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">اضافة سند صرف</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow:scroll;height:400px">
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill"
                            href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home"
                            aria-selected="false">كاش</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill"
                            href="#custom-content-below-profile" role="tab"
                            aria-controls="custom-content-below-profile" aria-selected="false">شيك</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane active show fade" id="custom-content-below-home" role="tabpanel"
                        aria-labelledby="custom-content-below-home-tab">
                        <form class="row mt-3"
                            action="{{ route('accounting.bonds.performance_bond.performance_bond_create') }}"
                            method="post" id="bonds_create" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">اختر عميل</label>
                                    <select required class="form-control select2bs4" name="client_id"
                                        id="invoice_select_id">
                                        <option value="">اختر عميل ...</option>
                                        @foreach ($clients as $key)
                                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">الرقم المرجعي</label>
                                    <input type="text" name="reference_number" class="form-control"
                                        placeholder="الرقم المرجعي">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">العملة</label>
                                    <select class="form-control select2bs4" required name="currency_id" id="">
                                        <option value="">اختر العملة ...</option>
                                        @foreach ($currencies as $key)
                                            <option value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">القيمة</label>
                                    <input required id="invoice_amount" type="text" name="amount"
                                        class="form-control text-center"
                                        style="background-color: palegoldenrod;font-size: 50px;height: 80px !important;vertical-align: middle;padding-top: 25px"
                                        pattern="[0-9]+" title="يجب ادخال ارقام فقط" placeholder="قيمة سند الصرف">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">الملاحظات</label>
                                    <textarea class="form-control" name="notes" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            {{-- <div class="col-md-1">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" value="cash"
                                            id="cash_for_client" name="customRadio" checked="">
                                        <label for="cash_for_client" class="custom-control-label">كاش</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" value="check"
                                            id="check_for_client" name="customRadio">
                                        <label for="check_for_client" class="custom-control-label">شيك</label>
                                    </div>
                                </div> --}}
                            <div class="col-md-12">
                                <button class="btn btn-sm btn-success">اضافة سند الصرف</button>
                            </div>

                        </form>
                    </div>
                    <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel"
                        aria-labelledby="custom-content-below-profile-tab">
                        <div class="row" id="check_information_client">
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <button type="button" onclick="add_check('')" class="btn btn-sm btn-success"><span
                                            class="fa fa-plus"></span>&nbsp;<span>من
                                            دفتري</span></button>
                                    <button type="button" onclick="open_search_check_modal()"
                                        class="btn btn-sm btn-success"><span class="fa fa-plus"></span>&nbsp;<span>
                                            من المحفظة
                                        </span></button>
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="checkNumber">رقم الشيك</label>
                                    <input required name="check_number" type="text" class="form-control"
                                        id="checkNumber" placeholder="رقم الشيك" pattern="[0-9]+"
                                        title="يرجى إدخال رقم شيك صحيح (الأرقام فقط)">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">تاريخ الاستحقاق</label>
                                    <input required name="due_date" id="due_date" type="date"
                                        class="form-control" placeholder="تاريخ الاستحقاق">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">اسم البنك</label>
                                    <input required name="bank_name" id="bank_name" type="text"
                                        class="form-control" placeholder="اسم البنك">
                                </div>
                            </div> --}}
                        </div>
                        <form class="row"
                            action="{{ route('accounting.bonds.performance_bond.performance_bond_check_create') }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">اختر عميل</label>
                                    <select required class="form-control select2bs4" name="client_id">
                                        <option value="">اختر عميل ...</option>
                                        @foreach ($clients as $key)
                                            <option value="{{ $key->id }}">{{ $key->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row" id="add_check_div">

                                </div>
                            </div>
                            <div class="col-md-12" style="display: none;" id="submit_button">
                                <button type="submit" class="btn btn-success btn-sm">اضافة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
