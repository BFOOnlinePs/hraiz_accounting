<div class="modal fade" id="create_order_from_order_sales">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">اختيار المنتجات للفاتورة</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('accounting.sales_invoices.create_purchase_invoices_from_order') }}"
                    method="post">
                    <input type="hidden" name="order_id" value="{{ $data->id ?? '' }}" id="order_input">
                    <input type="hidden" name="supplier_user_id" value="{{ $data->user_id ?? '' }}">

                    <div class="row">
                        <div class="col-md-12">
                            <label for="">اختر العملة</label>
                            <select required name="currency_id" class="form-control" id="">
                                @foreach($currency as $key)
                                    <option value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            {{-- <input type="text" onkeyup="product_list_ajax()" class="form-control" id="product_search"
                                placeholder="بحث عن صنف"> --}}
                            @csrf
                            <div class="table-responsive mt-2" id="order_sales_list">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">انشاء فاتورة</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
