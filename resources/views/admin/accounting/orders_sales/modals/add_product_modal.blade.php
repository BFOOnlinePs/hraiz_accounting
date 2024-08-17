<div class="modal fade" id="add_product_modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">اضافة منتجات</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" onkeyup="product_list_ajax()" class="form-control" id="product_search" placeholder="بحث عن صنف">
                <div class="table-responsive mt-2" id="product_list_table">

                </div>
            </div>
        </div>

    </div>

</div>
