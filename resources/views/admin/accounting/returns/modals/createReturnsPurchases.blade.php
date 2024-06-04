<div class="modal fade" id="create-purchases-returns-modal">
    <div class="modal-dialog modal-xl">
        <form style="width: 100%" action="{{ route('accounting.returns.create_return') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="returns_type" value="purchases">
            <input type="hidden" name="returns_type_invoice" id="returns_type_invoice" value="with_invoice">
            <input type="hidden" name="invoice_id" id="invoice_id_input_hidden">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة مردود مشتريات</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group d-flex">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input invoice_radio" type="radio" value="invoice" id="invoice" name="customRadio" checked="">
                                            <label for="invoice" class="custom-control-label">من فاتورة</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input invoice_radio" type="radio" value="not_invoice" id="not_invoice" name="customRadio">
                                            <label for="not_invoice" class="custom-control-label">من غير فاتورة</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div style="display: block" id="with_invoice">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select onchange="get_invoices_for_client(this.value)" class="form-control select2bs4" name="" id="client_id">
                                                <option value="">اختر عميل ...</option>
                                                @foreach($clients as $key)
                                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select onchange="get_invoice_items(this.value)" disabled class="form-control select2bs4" name="" id="invoice_id">
                                                <option value="">اختر فاتورة ...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <div style="max-height: 300px;overflow: scroll" id="invoice_items_table">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">ملاحظات</label>
                                            <textarea class="form-control" name="" id="note_text_invoice" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: none" id="with_not_invoice">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select onchange="selected_client_with_not_invoices(this.value)" class="form-control search_input select2bs4" name="" id="client_id_with_no_invoices">
                                                <option value="">اختر عميل ...</option>
                                                @foreach($clients as $key)
                                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{--                                    <div class="col-md-6" style="display: none" id="product_form_search">--}}
                                    {{--                                        <div class="form-group">--}}
                                    {{--                                            <input onkeyup="product_table(this.value)" type="text" class="form-control" placeholder="بحث عن صنف">--}}
                                    {{--                                            <div class="table-responsive">--}}
                                    {{--                                                <div id="product_table">--}}

                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-dark">اضافة مردود</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
