<div class="modal fade" id="order_sales_print_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">طباعة طلبية بيع</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('accounting.orders_sales.order_sales_pdf',['price_offer_id'=>$data->id]) }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">يرجى تحديد اللغة</label>
                                <select class="form-control" name="language" id="">
                                    <option value="ar">العربية</option>
                                    <option value="en">الانجليزية</option>
                                    <option value="he">عبري</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark">طباعة</button>
                </form>
            </div>
        </div>

    </div>

</div>
