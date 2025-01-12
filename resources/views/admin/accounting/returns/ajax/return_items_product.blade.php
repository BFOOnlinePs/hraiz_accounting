<table class="w-100 table-xs table-hover text-center table-bordered">
    <thead>
    <tr>
        <th>المنتج</th>
        <th>السعر</th>
        <th>الكمية</th>
        {{-- <th>الوحدة</th> --}}
        <th>المجموع</th>
        {{-- <th>المخزن</th> --}}
        {{-- <th>ملاحظات</th> --}}
        <th></th>
    </tr>
    </thead>
    <tbody>
        @if($data->isEmpty())
            <tr>
                <td colspan="6" class="text-center">لا توجد بيانات</td>
            </tr>
        @else
            @php
                $total_price = 0;
            @endphp
            @foreach($data as $index => $key)
            @php
                $total_price += $key->product_price * $key->qty;
            @endphp
                <tr>
                    <td>{{ $key->product->product_name_ar }}</td>
                    <td><span>{{ $key->product_price }}</span> <span></span></td>
                    <td class="justify-content-center align-items-center">
                        @if($returns->invoice_id != -1)
                            <span><input class="text-center"  min="0" @if($returns->status == 'stage') disabled @endif onchange="update_qty_from_return_items({{ $key->id }} , this.value , {{$key->invoice_qty}},this)" style="display: inline !important;width: 60px" type="number" class="" value="{{ $key->qty }}" tabindex="{{ $index + 1 }}"></span> | <span>{{ $key->invoice_qty }}</span>
                        @else
                            {{ $key->qty }}
                        @endif
                    </td>
                    <td>
                        {{ $key->product_price * $key->qty }}
                    </td>
                    {{-- <td>{{ $key->unit_id }}</td> --}}
                    {{-- <td>
                        <select onchange="update_wherehouse({{ $key->id }} , this.value)" @if($returns->status == 'stage') disabled @endif style="width: 100%" class="select2bs4" name="" id="">
                            @foreach($wherehouses as $item)
                                <option @if($item->id == $key->wherehouse_id) selected @endif value="{{ $item->id }}">{{ $item->wherehouse_name }}</option>
                            @endforeach
                        </select>
                    </td> --}}
                    {{-- <td>{{ $key->notes }}</td> --}}
                    <td>
                        <button @if($returns->status == 'stage') disabled @endif onclick="remove_item_from_return_items({{ $key->id }})" class="btn btn-sm btn-danger btn-xs">X</button>
                    </td>
                </tr>
            @endforeach
            <tr class="bg-dark">
                <td colspan="3" class="text-center">المجموع</td></td>
                <td colspan="1">{{ $total_price }}</td>
                <td></td>
            </tr>
        @endif
    </tbody>
</table>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4',
    })
</script>
