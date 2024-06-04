<div class="modal fade" id="create_production_lines_modal">
    <div class="modal-dialog">
        <form action="{{ route('product.product_lines_create') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $data->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة خط انتاج</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اسم خط الانتاج</label>
                                <input name="production_name" class="form-control" type="text"
                                       placeholder="اكتب اسم خط الانتاج" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">صورة للعلم</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="production_image" class="custom-file-input"
                                               id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">اختر ملف</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">رفع الصورة</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">ملاحظات</label>
                                <textarea class="form-control" name="production_notes" id="" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>

            </div>
        </form>

    </div>
</div>
