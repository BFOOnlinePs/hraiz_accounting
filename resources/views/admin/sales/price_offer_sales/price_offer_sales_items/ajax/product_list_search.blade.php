<table class="table table-sm table-hover border-bottom">
    <thead>
        <tr>
            <th style="width: 30px"></th>
            <th>اسم الصنف</th>
        </tr>
    </thead>
    <tbody>
        @if (!$data->isEmpty())
            @foreach ($data as $key)
                <tr>
                    <td>
                        <input onchange="create_price_offer_sales_items_ajax({{ $key->id }})" type="checkbox">
                    </td>
                    <td>{{ $key->barcode }}</span> | <span>{{ $key->product_name_ar }}</span></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="2" class="text-center">لا توجد نتائج</td>
            </tr>
        @endif
    </tbody>
</table>
{{ $data->links() }}
