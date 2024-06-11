<div class="modal fade" id="wherehouseCreateModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('wherehouse.create') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">اضافة مخزن</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اسم المخزن</label>
                                <input required type="text" name="wherehouse_name" class="form-control" placeholder="اسم المخزن">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">رقم الهاتف</label>
                                <input required type="text" name="wherehouse_phone" class="form-control" placeholder="رقم الهاتف">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">نوع المخزن</label>
                                <select required class="form-control" name="wherehouse_type">
                                    <option value="wherehouse">مخزن</option>
                                    <option value="pos">نقطة بيع</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">العنوان</label>
                                <textarea class="form-control" name="wherehouse_address" cols="30" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">المسؤول عن المخزن</label>
                                <select required class="form-control select2bs4" name="wherehouse_store_manager">
                                    <option value="">اختر مسؤول ...</option>
                                    @foreach($employee as $key)
                                        <option value="{{ $key->id }}">{{ $key->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-dark">اضافة</button>
                </div>
            </form>
        </div>

    </div>

</div>
