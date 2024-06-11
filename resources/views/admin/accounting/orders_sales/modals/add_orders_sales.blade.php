<div class="modal fade" id="add_orders_sales_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('accounting.orders_sales.create') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">اضافة طلبية بيع</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اسم الزبون</label>
                                <select class="form-control select2bs4" name="user_id" id="">
                                    <option value="">اختر زبون ...</option>
                                    @foreach($clients as $key)
                                        <option value="{{ $key->id }}">{{ $key->name }}
                                            <span>(</span>
                                            @foreach(json_decode($key->user_role) as $key)
                                                {{ \App\Models\UserRole::where('id',$key)->first()->name }} ,
                                            @endforeach
                                            <span>)</span>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">الرقم المرجعي</label>
                            <input type="text" class="form-control" name="reference_number" placeholder="الرقم المرجعي">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-success">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
