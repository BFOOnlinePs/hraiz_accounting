<div class="modal fade" id="sales_price_offer_items">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">الاصناف داخل عرض سعر البيع</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('accounting.orders_sales.create_order_sales_from_price_offer') }}"
                    method="post">
                    <input type="hidden" name="price_offer_sales_id" id="price_offer_sales_id_input">
                    <input type="hidden" name="supplier_id" id="supplier_user_id_input">
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <input type="text" onkeyup="product_list_ajax()" class="form-control" id="product_search"
                                placeholder="بحث عن صنف"> --}}
                            @csrf
                            <div class="table-responsive mt-2" id="price_offer_sales_items_table">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">حفظ</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
