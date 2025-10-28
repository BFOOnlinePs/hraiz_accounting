<table class="w-100 table-striped table-hover table-bordered">
    <thead class="bg-dark">
    <tr>
        <th class="text-center">#</th>
        <th>الباركود</th>
        <th>الصنف</th>
        <th style="width: 10%">الكمية</th>
        <th style="width: 10%">السعر</th>
        <th style="width: 10%" class="text-center">المجموع</th>
        @if ($order_items->order_status == 'invoice_has_not_been_posted' && in_array('1', json_decode(auth()->user()->user_role)))
            <th style="width: 100px" class="text-center">العمليات</th>
        @endif
    </tr>
    </thead>
    <tbody>
    @if ($data->isEmpty())
        <tr>
            <td colspan="7" class="text-center">لا توجد اصناف</td>
        </tr>
    @else
        @foreach ($data as $key)
            <tr>
                <td class="text-center">{{ $loop->index + 1 }}</td>
                <td>{{ $key->product->barcode }}</td>
                <td>{{ $key->product->product_name_ar }}</td>
                <td>
                    {{-- Added 'item-qty' class for easy selection with jQuery --}}
                    <input pattern="[0-9.]+" title="please enter number only" tabindex="{{ $loop->index + 1 }}"
                           @if ($order_items->order_status == 'invoice_has_been_posted' || in_array('11', json_decode(auth()->user()->user_role))) disabled @endif type="text"
                           onchange="update_orders_sales_items({{ $key->id }} ,'qty',this.value)"
                           class="form-control item-qty" value="{{ $key->qty }}">
                </td>
                <td>
                    {{-- Added 'item-price' class for easy selection with jQuery --}}
                    <input pattern="[0-9.]+" title="please enter number only"
                           @if ($order_items->order_status == 'invoice_has_been_posted' || in_array('11', json_decode(auth()->user()->user_role))) disabled @endif type="text"
                           onchange="update_orders_sales_items({{ $key->id }},'price',this.value)"
                           class="form-control item-price" value="{{ $key->price }}">
                </td>
                <td class="text-center row-total">
                    {{-- This will be updated dynamically --}}
                    {{ $key->qty * $key->price }}
                </td>
                @if ($order_items->order_status != 'invoice_has_not_been_posted' && in_array('1', json_decode(auth()->user()->user_role)))
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
    {{-- Added a footer for the grand total --}}
    <tfoot class="bg-light">
    <tr>
        <td colspan="5" class="text-bold text-center">المجموع الكلي</td>
        <td id="grand_total" class="text-center text-bold">
            {{ number_format($data->sum(function($item) { return $item->qty * $item->price; }), 2, '.', '') }}
        </td>
        @if ($order_items->order_status == 'invoice_has_not_been_posted' && in_array('1', json_decode(auth()->user()->user_role)))
            <td></td>
        @endif
    </tr>
    </tfoot>
</table>
