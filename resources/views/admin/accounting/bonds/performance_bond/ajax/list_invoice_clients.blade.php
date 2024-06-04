<table class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th>الرقم المرجعي</th>
            <th>العميل</th>
            <th>تاريخ الفاتورة</th>
            <th>تاريخ الاستحقاق</th>
            <th>نوع الفاتورة</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @if($data->isEmpty())
        <tr>
            <td colspan="5" class="text-center">لا توجد نتائج للبحث</td>
        </tr>
    @else
        @foreach($data as $key)
            <tr>
                <td>{{ $key->invoice_reference_number }}</td>
                <td>{{ $key->client->name }}</td>
                <td>{{ $key->bill_date }}</td>
                <td>{{ $key->due_date }}</td>
                <td>
                    @if($key->invoice_type == 'sales')
                        مبيعات
                    @elseif($key->invoice_type == 'purchases')
                        مشتريات
                    @endif
                </td>
                <td>
                    <a target="_blank" href="@if($key->invoice_type == 'sales') {{ route('accounting.sales_invoices.invoice_view',['id'=>$key->id]) }} @else {{ route('accounting.purchase_invoices.invoice_view',['id'=>$key->id]) }} @endif" class="btn btn-dark btn-sm"><span class="fa fa-eye"></span></a>
                    <button onclick="select_get_invoice_number_from_select_invoice({{ $key->id }})" class="btn btn-sm btn-success"><span class="fa fa-check"></span></button>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
<div id="pagination">

</div>
