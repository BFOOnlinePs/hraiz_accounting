<div class="modal fade" id="price_offer_found_modal">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('accounting.orders_sales.add_price_offer_sales_to_order_sales') }}"
            id="price_offer_found_form" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="customer_id" value="{{ $price_offer_sales->customer_id }}">
            <input type="hidden" name="price_offer_sales_id" value="{{ $price_offer_sales->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة طلبية بيع من عرض السعر</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="price_offer_sales_product_table">

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-dark">انشاء طلبية بيع</button>
                </div>

            </div>
        </form>
    </div>
</div>
