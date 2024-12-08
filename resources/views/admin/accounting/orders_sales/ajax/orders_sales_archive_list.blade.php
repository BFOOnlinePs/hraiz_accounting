<table class="w-100 text-center table-bordered table-hover table-striped">
    <thead class="bg-dark">
        <tr>
            <td style="width: 50px">#</td>
            <th style="width: 17%">الرقم المرجعي</th>
            <th>الزبون</th>
            <th>الفواتير المرتبطة بالطلبية</th>
            <th style="width: 17%">تمت الاضافة</th>
            <th style="width: 12%">حالة الطلبية</th>
            <th style="width: 100px">العمليات</th>
        </tr>
    </thead>
    <tbody>
        @if ($data->isEmpty())
            <tr>
                <td colspan="7" class="text-center">لا يوجد بيانات</td>
            </tr>
        @else
            @foreach ($data as $key)
                <tr>
                    <td>{{ ($data->currentPage()-1) * $data->perPage() + $loop->index + 1 }}</td>
                    <td>{{ $key->reference_number }}</td>
                    <td>{{ $key->client->name }}</td>
                    <td>
                        @if ($key->getInvoices != null)
                            @foreach ($key->getInvoices as $item)
                                <a href="{{ route('accounting.sales_invoices.invoice_view',['id'=>$item->id ?? ''])}}" class="badge badge-success">{{ $item->id }}</a>
                            @endforeach
                        @endif
                    </td>
                    <td>{{ $key->inserted_at }}</td>
                    <td>
                        <select id="select_order_status_{{ $key->id }}"
                            onchange="update_order_sales_status_ajax({{ $key->id }},this.value)"
                            class="select2bs4 w-100 btn-xs @if ($key->order_status == 'new') bg-info @elseif($key->order_status == 'invoice_send_preparation') bg-primary @elseif($key->order_status == 'pending') bg-warning @elseif($key->order_status == 'ready') bg-success @endif "
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
                    <td>
                        <a href="{{ route('accounting.orders_sales.orders_sales_details', ['order_id' => $key->id]) }}"
                            class="btn btn-dark btn-xs"><span class="fa fa-search"></span></a>
                        <a href="{{ route('accounting.orders_sales.archive.restore_archive_order_sales',['id'=>$key->id ?? '']) }}" class="btn btn-success btn-xs"><span class="fa fa-trash-arrow-up"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<div class="container">
    {{ $data->links() }}
</div>
