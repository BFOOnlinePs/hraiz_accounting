<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true" id="modal-lg-language">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        {{-- <form action="{{ route('procurement_officer.orders.create_order_items') }}" method="POST">
            @csrf --}}
        <input type="hidden" id="order_id" value="{{ $order->id }}" name="order_id">
            <form class="modal-content" action="{{ route('procurement_officer.orders.product.product_list_pdf') }}"
                method="POST">

                <div class="modal-header" align="center">
                    <h4 class="modal-title">اختر لغة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @csrf
                        <input type="text" name="order_id" value="{{ $order->id }}" style="display: none">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اختر لغة</label>
                                <select name="language" id="language" class="form-control">
                                    <option value="ar">العربية</option>
                                    <option value="en">الانجليزية</option>
                                    <option value="he">العبرية</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-dark">عرض</button>
                </div>
            </form>
        {{-- </form> --}}
    </div>
</div>
