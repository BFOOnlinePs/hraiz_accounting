<div class="modal fade" id="open_print_modal">
    <div class="modal-dialog modal-xl">
        <?php echo csrf_field(); ?>
        <form class="modal-content"
            action="<?php echo e(route('accounting.account-statement.print_account_statement_details_pdf')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h4 class="modal-title">اضافة مصروف</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
                    <input type="hidden" name="user_type" value="<?php echo e($user_type); ?>">
                    <input type="hidden" name="account_statment_type" id="statement_type_print">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>اللغة</label>
                            <select name="language" class="form-control">
                                <option value="ar">العربية</option>
                                <option value="en">الانجليزية</option>
                                <option value="he">العبرية</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-dark">عرض</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\xampp2\htdocs\projects\hraiz_accounting\resources\views/admin/accounting/account_statement/modals/language_print.blade.php ENDPATH**/ ?>