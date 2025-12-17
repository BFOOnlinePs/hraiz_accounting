<table class="w-100 table-hover text-center table-bordered table-striped">
    <thead class="bg-dark">
    <tr>
        <th>الرقم المرجعي للفاتورة</th>
        <th>اسم العميل</th>
        <th>نوع المردود</th>
        <th>التاريخ</th>
        <th>ملاحظات</th>
        <th style="width: 70px"></th>
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
                    <td>
                        @if(empty($key->invoice->invoice_reference_number))
                            من غير فاتورة
                        @else
                            <a href="{{ route('accounting.returns.returns_details',['id'=>$key->id]) }}">{{ $key->invoice->invoice_reference_number }}</a>
                        @endif
{{--                        {{ $key->invoice->invoice_reference_number ?? 'من غير فاتورة' }}--}}
                    </td>
                    <td>{{ $key->invoice->client->name ?? '' }}</td>
                    <td>
                        @if($key->returns_type == 'sales')
                            <span class="w-100 badge badge-success">مبيعات</span>
                        @else
                            <span class="w-100 badge badge-warning">مشتريات</span>
                        @endif
                    </td>
                    <td>{{ $key->created_at }}</td>
                    <td>{{ $key->notes }}</td>
                    <td>
                        <a href="{{ route('accounting.returns.returns_details',['id'=>$key->id]) }}" class="btn btn-dark btn-xs"><span class="fa fa-search"></span></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{ $data->links() }}
