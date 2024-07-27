<table class="table table-sm table-bordered table-hover">
    <thead>
    <tr>
        <th>الرقم المرجعي</th>
        <th>الزبون</th>
        <th>حالة الطلبية</th>
        <th>العملة</th>
        <th>تمت الاضافة</th>
        <th>العمليات</th>
    </tr>
    </thead>
    <tbody>
        @if($data->isEmpty())
            <tr>
                <td colspan="6" class="text-center">لا يوجد بيانات</td>
            </tr>
        @else
            @foreach($data as $key)
                <tr>
                    <td>{{ $key->reference_number }}</td>
                    <td>{{ $key->client->name }}</td>
                    <td>{{ $key->user_status }}</td>
                    <td>{{ $key->currency }}</td>
                    <td>{{ $key->inserted_at }}</td>
                    <td>
                        <a href="{{ route('accounting.orders_sales.orders_sales_details',['order_id'=>$key->id]) }}" class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>
                        <a href="" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
