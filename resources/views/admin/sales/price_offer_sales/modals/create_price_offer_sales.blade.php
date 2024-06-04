<div class="modal fade" id="create_price_offer_sales_modal">
    <div class="modal-dialog">
        <form action="{{ route('price_offer_sales.create') }}" method="post" enctype="multipart/form-data">
            @csrf
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
                                <label for="">اسم الزبون</label>
                                <select required class="form-control select2bs4" name="customer_id" id="">
                                    <option value="">اختر زبون ...</option>
                                    @foreach($clients as $key)
                                        <option value="{{ $key->id }}">{{ $key->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">العملة</label>
                                <select class="form-control select2bs4" name="currency_id" id="">
                                    @foreach($currency as $key)
                                        <option value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الملاحظات</label>
                                <textarea class="form-control" name="notes" id="" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-dark">حفظ</button>
                </div>

            </div>
        </form>
    </div>
</div>
