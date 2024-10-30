<table class="table table-sm text-center table-bordered table-hover">
    <thead>
        <tr>
            <th>الرقم المرجعي</th>
            <th>القيمة</th>
            <th>الملاحظات</th>
            <th>العملة</th>
            <th>نوع الدفعة</th>
            <th>اضيفت بواسطة</th>
            <th>الى العميل</th>
            <th>العمليات</th>
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
                    <td>{{ $key->reference_number }}</td>
                    <td>{{ $key->amount }}</td>
                    <td>{{ $key->notes }}</td>
                    <td>{{ $key->currency->currency_name }}</td>
                    <td>
                        @if ($key->payment_type == 'cash')
                            <small class="badge badge-info">كاش</small>
                        @else
                            <small class="badge badge-warning"><span>شيك </span><span data-toggle="modal"
                                    data-target="#update_check_payment_type_modal"
                                    onclick="get_check_data({{ $key }})"
                                    class="fa fa-money-check"></span></small>
                        @endif
                    </td>
                    <td>{{ $key->users->name }}</td>
                    <td>
                        {{ $key->client->name ?? '' }}
                        {{--                    @if ($key->invoice) --}}
                        {{--                        @php --}}
                        {{--                            $client = \App\Models\User::find($key->invoice->client_id); --}}
                        {{--                        @endphp --}}
                        {{--                        {{ $client ? $client->name : '' }} --}}
                        {{--                    @else --}}
                        {{--                        لا يوجد مستخدم --}}
                        {{--                    @endif --}}
                    </td>
                    <td>
                        <a href="{{ route('accounting.bonds.details', ['id' => $key->id]) }}"
                            class="btn btn-sm btn-dark"><span class="fa fa-search"></span></a> <a
                            href="{{ route('accounting.bonds.performance_bond.edit_performance_bonds', ['id' => $key->id]) }}"
                            {{-- class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                        <a href="" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a> --}} </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
