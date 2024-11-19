<table class="w-100 text-center table-hover table-bordered table-striped">
    <thead class="bg-dark">
        <tr>
            <th style="width: 17%">تاريخ الاضافة</th>
            <th style="width: 17%">الزبون</th>
            <th style="width: 17%">بواسطة</th>
            <th >ملاحظات</th>
            <th style="width: 100px">العملة</th>
            <th style="width: 100px"></th>
        </tr>
    </thead>
    <tbody>
        @if (!$data->isEmpty())
            @foreach ($data as $key)
                <tr>
                    <td>{{ $key->insert_at }}</td>
                    <td>{{ $key->user->name }}</td>
                    <td>{{ $key->insert_by_user->name }}</td>
                    <td>{{ $key->notes }}</td>
                    <td>{{ $key->currency->currency_name }}</td>
                    <td>
                        <a href="{{ route('price_offer_sales.price_offer_sales_items.price_offer_sales_items_index', ['id' => $key->id]) }}"
                            class="btn btn-dark btn-xs"><span class="fa fa-search"></span></a>
                        <a class="btn btn-danger btn-xs" href=""><span class="fa fa-trash"></span></a>
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
