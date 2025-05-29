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
                <form action="<?php echo e(route('accounting.sales_invoices.create_purchase_invoices_from_order')); ?>"
                    method="post">
                    <input type="hidden" name="order_id" value="<?php echo e($data->id ?? ''); ?>" id="order_input">
                    <input type="hidden" name="supplier_user_id" value="<?php echo e($data->user_id ?? ''); ?>">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <?php echo csrf_field(); ?>
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
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/orders_sales/modals/create_order_from_order_sales.blade.php ENDPATH**/ ?>