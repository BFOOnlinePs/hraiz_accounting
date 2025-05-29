
























<div style="position: fixed; left: 20px; bottom: 0px;height:500px" id="toastsContainerBottomLeft"
     class="toasts-bottom-left fixed bg-info">
    <div class="toast fade" style="background-color:rgba(255,255,255,.85);width: 100%; height: 100%;" id="form_product" role="alert"
         aria-live="assertive" aria-atomic="true" >
        <div class="toast-header">
            <strong class="mr-auto">قائمة الأصناف</strong>
            <button type="button" class="ml-2 mb-1 close" onclick="close_form_product()">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="toast-body bg-info">
            <input type="text" id="product_search" onkeyup="product_list_search()"
                   class="form-control" placeholder="بحث عن عنصر">
            <div style="width: 300px;display:block" class="mt-2">
                <div id="product_list_search">

                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/sales/price_offer_sales/price_offer_sales_items/modals/product_search.blade.php ENDPATH**/ ?>