<div class="modal fade" id="expenses-category-edit-modal">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('accounting.expenses_category.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="expenses_category_id" id="expenses_category_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة مصروف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for=""></label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="اسم التصنيف">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-dark">تعديل التصنيف</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </form>
    </div>
</div>
