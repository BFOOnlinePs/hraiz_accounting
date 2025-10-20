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
                <form target="_blank" action="{{ route('accounting.orders_sales.order_sales_pdf', ['price_offer_id' => $data->id]) }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <table style="width: 100%">
                                    <tr>
                                        <td style="width: 30%">يرجى تحديد اللغة</td>
                                        <td style="width: 70%">
                                            <select class="form-control" name="language" id="">
                                                <option value="ar">العربية</option>
                                                <option value="en">الانجليزية</option>
                                                <option value="he">العبرية</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group clearfix">
                                    <div class="icheck-danger d-inline">
                                        <input type="radio" name="radio_button" value="radio_A4" checked=""
                                            id="print_a4">
                                        <label for="print_a4">
                                        </label>
                                    </div>
                                    <div class="icheck-danger d-inline">
                                        <label for="print_a4">
                                            طباعة طلبية A4 مع أسعار
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group clearfix">
                                    <div class="icheck-danger d-inline">
                                        <input type="radio" name="radio_button" value="radio_A4_non_price"
                                            id="print_a4_non_price">
                                        <label for="print_a4_non_price">
                                        </label>
                                    </div>
                                    <div class="icheck-danger d-inline">
                                        <label for="print_a4_non_price">
                                            طباعة طلبية A4 بدون أسعار
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group clearfix">
                                    <div class="icheck-danger d-inline">
                                        <input type="radio" name="radio_button" value="radio_qr" id="print_qr">
                                        <label for="print_qr">
                                        </label>
                                    </div>
                                    <div class="icheck-danger d-inline">
                                        <label for="print_qr">
                                            طباعة ليبل
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive" id="list_order_sales_product_for_qr">

                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark">عرض</button>
                </form>
            </div>
        </div>

    </div>

</div>
