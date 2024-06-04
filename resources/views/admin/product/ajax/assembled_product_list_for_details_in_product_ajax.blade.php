<div class="p-2 m-2">
    @foreach($data as $key)
        <input type="hidden" name="assembled_product[]" value="{{ $key->assembled_product }}">
        <input class="form-control" type="text" name="" value="{{ App\Models\ProductModel::where('id',$key->assembled_product)->first()->product_name_ar }}">
    @endforeach
</div>
