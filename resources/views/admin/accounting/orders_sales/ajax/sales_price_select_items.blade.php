<table class="table table-sm table-striped table-hover">
    <thead>
        <tr>
            <th></th>
            <th>الباركود</th>
            <th>الصنف</th>
            <th>الكمية</th>
            <th>السعر</th>
            @if (
                $order_items->order_status == 'invoice_has_not_been_posted' &&
                    in_array('1', json_decode(auth()->user()->user_role)))
                <th>العمليات</th>
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
                    <td><input name="select_items[]" value="{{ $key->id }}" type="checkbox">{{ $key->id }}</td>
                    <td>{{ $key->product->barcode }}</td>
                    <td>{{ $key->product->product_name_ar }}</td>
                    <td><input @if ($order_items->order_status == 'invoice_has_been_posted' || in_array('11', json_decode(auth()->user()->user_role))) disabled @endif type="number"
                            onchange="update_orders_sales_items({{ $key->id }} ,'qty',this.value)"
                            class="form-control" value="{{ $key->qty }}"></td>
                    <td><input @if ($order_items->order_status == 'invoice_has_been_posted' || in_array('11', json_decode(auth()->user()->user_role))) disabled @endif type="number"
                            onchange="update_orders_sales_items({{ $key->id }},'price',this.value)"
                            class="form-control" value="{{ $key->price }}"></td>
                    @if (
                        $order_items->order_status == 'invoice_has_not_been_posted' &&
                            in_array('1', json_decode(auth()->user()->user_role)))
                        <td>
                            <button class="btn btn-danger btn-sm"
                                onclick="delete_orders_sales_items({{ $key->id }})"><span
                                    class="fa fa-close"></span></button>
                        </td>
                    @endif
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
