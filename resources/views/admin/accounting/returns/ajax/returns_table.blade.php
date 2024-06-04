<table class="table table-sm table-hover table-bordered">
    <thead>
    <tr>
        <th>الرقم المرجعي للفاتورة</th>
        <th>نوع المردود</th>
        <th>ملاحظات</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
        @if($data->isEmpty())
            <tr>
                <td colspan="4" class="text-center">لا توجد بيانات</td>
            </tr>
        @else
            @foreach($data as $key)
                <tr>
                    <td>{{ $key->invoice->invoice_reference_number ?? 'من غير فاتورة' }}</td>
                    <td>
                        @if($key->returns_type == 'sales')
                            مبيعات
                        @else
                            مشتريات
                        @endif
                    </td>
                    <td>{{ $key->notes }}</td>
                    <td>
                        <a href="{{ route('accounting.returns.returns_details',['id'=>$key->id]) }}" class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{ $data->links() }}
