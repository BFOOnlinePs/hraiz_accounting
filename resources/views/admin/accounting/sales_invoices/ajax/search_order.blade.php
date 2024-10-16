<table style="width: 100%" class="table table-sm table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 10px">#</th>
            <th style="width: 150px">اسم العميل</th>
            <th>تاريخ الاضافة</th>
            <th style="width: 120px">ملاحظات</th>
            <th style="width: 120px">العملة</th>
            <th>عروض الاسعار</th>
            <th style="width: 350px"></th>
        </tr>
    </thead>
    <tbody>
        @if (!$data->isEmpty())
            @foreach ($data as $key)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $key['client']->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($key->insert_at)->toDateString() }}</td>

                    <td>{{ $key->notes }}</td>
                    <td>{{ $key->currency->currency_name ?? '' }}</td>
                    <td>
                        @foreach ($key->price_offers as $price_offer)
                            <a style="display: inline"
                                href="{{ route('accounting.sales_invoices.invoice_view', ['id' => $price_offer->id]) }}">{{ $price_offer->created_at }}</a>
                        @endforeach
                    </td>
                    <td>
                        <button onclick="get_order_id({{ $key->id }},{{ $key->client->id }})" type="submit"
                            class="btn btn-success btn-sm"><span class="fa fa-check"></span>&nbsp; انشاء فاتورة من طلبية
                            بيع</button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="text-center">لا توجد بيانات</td>
            </tr>
        @endif
    </tbody>
</table>

<script>
    function get_order_id(id, supplier_id) {
        document.getElementById('order_input').value = id;
        document.getElementById('supplier_input').value = supplier_id;
    }
</script>
