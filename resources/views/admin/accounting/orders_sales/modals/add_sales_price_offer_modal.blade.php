<div class="modal fade" id="add_sales_price_offer_modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">اضافة طلبية لعرض سعر</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <select class="form-control select2bs4" onchange="list_price_offer_sales_ajax()" name="" id="select_client">
                                <option value="">جميع المستخدمين</option>
                                @foreach($clients as $key)
                                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive" id="sales_price_offer_table">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
