<table class="table text-center table-sm table-bordered table-hover">
    @foreach ($data as $key)
        <tbody>
            <tr>
                <th>{{ $key->product->barcode }}</th>
                <th>{{ $key->product->product_name_ar }}</th>
                <th>
                    <input type="text" min="1" required value="1" class="form-control text-center"
                        placeholder="العدد المطلوب للطباعة" name="items[{{ $key->product->id }}]">
                </th>
            </tr>
        </tbody>
    @endforeach
</table>
