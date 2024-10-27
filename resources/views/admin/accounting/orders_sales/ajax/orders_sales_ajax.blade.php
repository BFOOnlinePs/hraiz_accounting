<table class="table table-sm text-center table-bordered table-hover">
    <thead>
        <tr>
            <th>الرقم المرجعي</th>
            <th>الزبون</th>
            <th style="width: 15%">حالة الطلبية</th>
            <th>تمت الاضافة</th>
            <th style="width: 80px">العمليات</th>
        </tr>
    </thead>
    <tbody>
        @if ($data->isEmpty())
            <tr>
                <td colspan="6" class="text-center">لا يوجد بيانات</td>
            </tr>
        @else
            @foreach ($data as $key)
                <tr>
                    <td>{{ $key->reference_number }}</td>
                    <td>{{ $key->client->name }}</td>
                    <td>
                        <select id="select_order_status_{{ $key->id }}"
                            onchange="update_order_sales_status_ajax({{ $key->id }},this.value)"
                            class="select2bs4 form-control @if ($key->order_status == 'new') bg-info @elseif($key->order_status == 'invoice_send_preparation') bg-primary @elseif($key->order_status == 'pending') bg-warning @elseif($key->order_status == 'ready') bg-success @endif "
                            name="" id="">
                            <option @if ($key->order_status == 'new') selected @endif value="new">جديدة</option>
                            <option @if ($key->order_status == 'invoice_send_preparation') selected @endif value="invoice_send_preparation">
                                تم
                                ارسالها الى التحضير</option>
                            <option @if ($key->order_status == 'pending') selected @endif value="pending">قيد الانتظار
                            </option>
                            <option @if ($key->order_status == 'ready') selected @endif value="ready">جاهزة</option>
                        </select>
                    </td>
                    <td>{{ $key->inserted_at }}</td>
                    <td>
                        <a href="{{ route('accounting.orders_sales.orders_sales_details', ['order_id' => $key->id]) }}"
                            class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>
                        <a href="" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<div class="container">
    {{ $data->links() }}
</div>
