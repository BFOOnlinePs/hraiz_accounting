<table class="table table-sm table-hover table-bordered">
    <thead>
    <tr>
        <th>الزبون</th>
        <th>تاريخ الاضافة</th>
        <th>تمت الاضافة بواسطة</th>
        <th>ملاحظات</th>
        <th>العملة</th>
        <th>العمليات</th>
    </tr>
    </thead>
    <tbody>
    @if(!$data->isEmpty())
        @foreach($data as $key)
            <tr>
                <td>{{ $key->user->name }}</td>
                <td>{{ $key->insert_at }}</td>
                <td>{{ $key->insert_by_user->name }}</td>
                <td>{{ $key->notes }}</td>
                <td>{{ $key->currency->currency_name }}</td>
                <td>
                    <a class="btn btn-success btn-sm" href="{{ route('price_offer_sales.edit',['id'=>$key->id]) }}"><span class="fa fa-edit"></span></a>
                    <a href="{{ route('price_offer_sales.price_offer_sales_items.price_offer_sales_items_index',['id'=>$key->id]) }}" class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>
                    <a class="btn btn-danger btn-sm" href=""><span class="fa fa-trash"></span></a>
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
