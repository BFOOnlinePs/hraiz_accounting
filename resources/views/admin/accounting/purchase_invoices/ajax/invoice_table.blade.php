<table class="table table-bordered">
    <thead>
    <tr>
        <td>#</td>
        <td>الرقم المرجعي</td>
        <th>تاريخ الفاتورة</th>
        <th>تاريخ التسليم</th>
        <th>العميل</th>
        <th>الضريبة الاولى</th>
        <th>الضريبة الثانية</th>
        <th>الملاحظات</th>
        <th>العمليات</th>
    </tr>
    </thead>
    <tbody>
    @if($data->isEmpty())
        <tr>
            <td colspan="8" class="text-center">لا توجد بيانات</td>
        </tr>
    @else
        @foreach ($data as $key)
            <tr>
                <td>{{ ($data ->currentpage()-1) * $data ->perpage() + $loop->index + 1 }}</td>
                <td>{{ $key->invoice_reference_number }}</td>
                <td>{{ $key->bill_date }}</td>
                <td>{{ $key->due_date }}</td>
                <td>{{ App\Models\User::where('id',$key->client_id)->value('name') }}</td>
                <td>{{ $key->tax_id }}</td>
                <td>{{ $key->tax_id2 }}</td>
                <td>{{ $key->note }}</td>
                <td>
                    <a href="{{ route('accounting.purchase_invoices.invoice_view',['id'=>$key->id]) }}" class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>
                    <a href="{{ route('accounting.purchase_invoices.edit_invoices',['id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                    <a href="{{ route('accounting.purchase_invoices.delete_invoices',['id'=>$key->id]) }}" onclick="return confirm('هل تريد حذف البيانات ؟')" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                </td>
            </tr>
        @endforeach
        @foreach ($data as $key)
        @endforeach
    @endif
    </tbody>
</table>
{{ $data->links() }}
