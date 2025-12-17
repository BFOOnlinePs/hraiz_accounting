<table class="w-100 table-bordered text-center table-hover table-striped">
    <thead class="bg-dark">
        <tr>
            {{-- <td>#</td> --}}
            <td>الرقم المرجعي</td>
            <th>العميل</th>
            <th>تاريخ الفاتورة</th>
            <th>تاريخ التسليم</th>
            {{-- <th>الضريبة الاولى</th> --}}
            {{-- <th>الضريبة الثانية</th> --}}
            <th>الملاحظات</th>
            <th>الحالة</th>
            <th style="width: 130px">العمليات</th>
        </tr>
    </thead>
    <tbody>
        @if ($data->isEmpty())
            <tr>
                <td colspan="8" class="text-center">لا توجد بيانات</td>
            </tr>
        @else
            @foreach ($data as $key)
                <tr>
                    {{-- <td>{{ ($data ->currentpage()-1) * $data ->perpage() + $loop->index + 1 }}</td> --}}
                    <td class="text-left">
                        <a href="{{ route('accounting.purchase_invoices.invoice_view', ['id' => $key->id]) }}">{{ $key->invoice_reference_number }}</a>
                    </td>
                    <td class="text-left">{{ App\Models\User::where('id', $key->client_id)->value('name') }}</td>
                    <td>{{ $key->bill_date }}</td>
                    <td>{{ $key->due_date }}</td>
                    {{-- <td>{{ $key->tax_id }}</td> --}}
                    {{-- <td>{{ $key->tax_id2 }}</td> --}}
                    <td>{{ $key->note }}</td>
                    <td class="text-center">
                        @if ($key->status == 'stage')
                            <span class="badge badge-success w-100">مرحل</span>
                        @else
                            <span class="badge badge-danger w-100">غير مرحل</span>
                        @endif
                    </td>
                    <td class=''>
                        <a href="{{ route('accounting.purchase_invoices.invoice_view', ['id' => $key->id]) }}"
                            class="btn btn-dark btn-xs"><span class="fa fa-search"></span></a>
                        <a href="{{ route('accounting.purchase_invoices.edit_invoices', ['id' => $key->id]) }}"
                            class="btn btn-success btn-xs"><span class="fa fa-edit"></span></a>
                        @if ($key->status == 'stage')
                            <button @if ($key->status == 'stage') disabled @endif
                                onclick="return confirm('هل تريد حذف البيانات ؟')" class="btn btn-danger btn-xs"><span
                                    class="fa fa-trash"></span></button>
                        @else
                            <a @if ($key->status == 'stage') disabled @endif
                                href="{{ route('accounting.purchase_invoices.delete_invoices', ['id' => $key->id]) }}"
                                onclick="return confirm('هل تريد حذف البيانات ؟')" class="btn btn-danger btn-xs"><span
                                    class="fa fa-trash"></span></a>
                        @endif
                    </td>
                </tr>
            @endforeach
            @foreach ($data as $key)
            @endforeach
        @endif
    </tbody>
</table>
{{ $data->links() }}
