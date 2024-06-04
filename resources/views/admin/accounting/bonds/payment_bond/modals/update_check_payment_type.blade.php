<div class="modal fade" id="update_check_payment_type_modal">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('accounting.purchase_invoices.create_purchase_invoices_from_order') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_id" id="order_input">
            <input type="hidden" name="supplier_user_id" id="supplier_input">
            <input type="hidden" name="invoice_type" value="sales">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">فاتورة من عرض سعر</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">بحث عن عرض سعر</label>
                                <input onkeyup="search_order_ajax()" id="input_search" type="text" class="form-control" placeholder="ابحث عن طلبية">
                                {{-- <select class="form-control select2bs4" name="order_id" id="">
                                    <option value="">اختر الطلبية</option>
                                    @foreach ($order as $key)
                                        <option value="{{ $key->id }}">{{ $key->reference_number }}</option>
                                    @endforeach
                                </select> --}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">المورد</label>
                                <select class="form-control select2bs4" name="supplier_id" onchange="search_order_ajax()" id="supplier_id">
                                    <option value="">اختر المورد</option>
                                    @foreach ($users as $key)
                                        <option value="{{ $key->id }}">{{ $key->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="search_order">

                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    {{-- <button type="submit" class="btn btn-primary">حفظ</button> --}}
                </div>
            </div>
        </form>
    </div>
</div>
