<table class="table table-sm table-striped table-hover">
    <thead>
        <tr>
            <th></th>
            <th>الباركود</th>
            <th>الصنف</th>
            <th>الكمية</th>
            <th>السعر</th>

        </tr>
    </thead>
    <tbody>
        @if ($data->isEmpty())
            <tr>
                <td colspan="5" class="text-center">لا توجد اصناف</td>
            </tr>
        @else
            @foreach ($data as $key)
                <tr>
                    <td><input name="select_items[]" value="{{ $key->id }}" checked type="checkbox"></td>
                    <td>{{ $key->product->barcode }}</td>
                    <td>{{ $key->product->product_name_ar }}</td>
                    <td><input type="number" name="quantities[{{ $key->id }}]" class="form-control"
                            value="{{ $key->qty }}"></td>
                    <td><input type="number" name="prices[{{ $key->id }}]" class="form-control"
                            value="{{ $key->price }}"></td>

                </tr>
            @endforeach
        @endif
    </tbody>
</table>
