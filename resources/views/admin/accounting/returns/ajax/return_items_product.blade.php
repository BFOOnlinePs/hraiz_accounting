<table class="w-100 table-xs table-hover text-center table-bordered">
    <thead>
    <tr>
        <th>المنتج</th>
        <th>السعر</th>
        <th>الكمية</th>
        <th>الوحدة</th>
        <th>المخزن</th>
        <th>ملاحظات</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
        @if($data->isEmpty())
            <tr>
                <td colspan="6" class="text-center">لا توجد بيانات</td>
            </tr>
        @else
            @foreach($data as $index => $key)
                <tr>
                    <td>{{ $key->product->product_name_ar }}</td>
                    <td>{{ $key->product->product_price }}</td>
                    <td class="justify-content-center align-items-center">
                        @if($returns->invoice_id != -1)
                            <span><input @if($returns->status == 'stage') disabled @endif onchange="update_qty_from_return_items({{ $key->id }} , this.value , {{$key->invoice_qty}},this)" style="display: inline !important;width: 60px" type="text" class="" value="{{ $key->qty }}" tabindex="{{ $index + 1 }}"></span> | <span>{{ $key->invoice_qty }}</span>
                        @else
                            {{ $key->qty }}
                        @endif
                    </td>
                    <td>{{ $key->unit_id }}</td>
                    <td>
                        <select onchange="update_wherehouse({{ $key->id }} , this.value)" @if($returns->status == 'stage') disabled @endif style="width: 100%" class="select2bs4" name="" id="">
                            @foreach($wherehouses as $item)
                                <option @if($item->id == $key->wherehouse_id) selected @endif value="{{ $item->id }}">{{ $item->wherehouse_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>{{ $key->notes }}</td>
                    <td>
                        <button @if($returns->status == 'stage') disabled @endif onclick="remove_item_from_return_items({{ $key->id }})" class="btn btn-sm btn-danger btn-xs">X</button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4',
    })
</script>
