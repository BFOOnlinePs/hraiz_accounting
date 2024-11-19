<table class="w-100 table-striped table-hover table-bordered">
    <thead class="bg-dark">
        <tr>
            <th>الباركود</th>
            <th>الصنف</th>
            <th style="width: 10%">الكمية</th>
            <th style="width: 10%">السعر</th>
            @if (
                $order_items->order_status == 'invoice_has_not_been_posted' &&
                    in_array('1', json_decode(auth()->user()->user_role)))
                <th style="width: 100px" class="text-center">العمليات</th>
            @endif
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
                    <td>{{ $key->product->barcode }}</td>
                    <td>{{ $key->product->product_name_ar }}</td>
                    <td><input pattern="[0-9]+" title="please enter number only" tabindex="{{ $loop->index + 1 }}"
                            @if ($order_items->order_status == 'invoice_has_been_posted' || in_array('11', json_decode(auth()->user()->user_role))) disabled @endif type="text"
                            onchange="update_orders_sales_items({{ $key->id }} ,'qty',this.value)"
                            class="" value="{{ $key->qty }}"></td>
                    <td>
                        <input pattern="[0-9]+" title="please enter number only"
                            @if ($order_items->order_status == 'invoice_has_been_posted' || in_array('11', json_decode(auth()->user()->user_role))) disabled @endif type="text"
                            onchange="update_orders_sales_items({{ $key->id }},'price',this.value)"
                            class="" value="{{ $key->price }}">
                    </td>
                    @if (
                        $order_items->order_status == 'invoice_has_not_been_posted' &&
                            in_array('1', json_decode(auth()->user()->user_role)))
                        <td class="text-center">
                            <button class="btn btn-danger btn-xs"
                                onclick="delete_orders_sales_items({{ $key->id }})"><span
                                    class="fa fa-close"></span></button>
                        </td>
                    @endif
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
