<div class="modal fade" id="add_print_language_modal">
    <div class="modal-dialog">
        <form action="<?php echo e(route('accounting.sales_invoices.sales_invoice_pdf')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="invoice_id" value="<?php echo e($purchase_invoice->id); ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اختيار لغة الطباعة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">لغة الطباعة</label>
                            <select required class="form-control" name="language" id="">
                                <option value="">اختر لغة الطباعة ...</option>
                                <option value="ar">عربية</option>
                                <option value="en">انجليزية</option>
                                <option value="he">عبري</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-warning">عرض</button>
                </div>

            </div>
        </form>

    </div>
</div>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/sales_invoices/invoices/modals/print_language.blade.php ENDPATH**/ ?>