<table class="table table-sm table-hover table-bordered">
    <thead>
        <tr>
            <th>الزبون</th>
            <th>القيمة</th>
            <th>العملة</th>
            <th>الوصف</th>
            <th>نوع العملية</th>
            <th>
                العمليات
            </th>
        </tr>
    </thead>
    <tbody>
        @if($data->isEmpty())
            <tr>
                <td colspan="5" class="text-center">لا يوحد نتائج</td>
            </tr>
        @else
            @foreach($data as $key)
                <tr>
                    <td>{{ $key->client->name??'' }}</td>
                    <td>{{ $key->amount }}</td>
                    <td>{{ $key->currency->currency_name??'' }}</td>
                    <td>{{ $key->notes }}</td>
                    <td>{{ $key->debt_credit }}</td>
                    <td>

                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
