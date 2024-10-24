<table class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th>رقم عرض السعر</th>
            <th>الزبون</th>
            <th>ملاحظات</th>
            <th>طلبيات مسبقة</th>
            <th class="w-25"></th>
        </tr>
    </thead>
    <tbody>
        @if ($data->isEmpty())
            <tr>
                <td colspan="4" class="text-center">لا يوجد عروض اسعار</td>
            </tr>
        @else
            @foreach ($data as $key)
                <tr>
                    <td>
                        <a href="{{ route('price_offer_sales.price_offer_sales_items.price_offer_sales_items_index', ['id' => $key->id]) }}"
                            target="_blank">{{ $key->id }}</a>
                    </td>
                    <td>{{ $key->user->name }}</td>
                    <td>{{ $key->notes }}</td>
                    <td>
                        @foreach ($key->orderSales as $order_sales)
                            <a
                                href="{{ route('accounting.orders_sales.orders_sales_details', ['order_id' => $order_sales->id]) }}">{{ $order_sales->reference_number }}</a>
                            ,
                        @endforeach
                    </td>
                    <td class="text-center">
                        <button class="btn btn-success btn-sm"
                            onclick="add_price_offer_sales_to_order_sales({{ $key }})">
                            اضافة طلبية بيع من عرض السعر هذا
                        </button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
