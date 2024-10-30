<table class="table table-sm text-center table-bordered table-hover">
    <thead>
        <tr>
            <th>الرقم المرجعي</th>
            <th>القيمة</th>
            <th>الملاحظات</th>
            <th>العملة</th>
            <th>نوع الدفعة</th>
            <th>اضيفت بواسطة</th>
            <th>العميل</th>
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
                    <td>
                        {{ \App\Models\User::where('id', $key->insert_by)->first()->name ?? '' }}
                    </td>
                    <td>
                        {{ \App\Models\User::where('id', $key->client_id)->first()->name ?? '' }}
                    </td>
                    <td>
                        <a href="{{ route('accounting.bonds.details', ['id' => $key->id]) }}"
                            class="btn btn-sm btn-dark"><span class="fa fa-search"></span></a>
                        {{-- <a href="{{ route('accounting.bonds.payment_bond.edit_payment_bonds', ['id' => $key->id]) }}"
                            class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a> --}}
                        {{-- <a href="" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a> --}}
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
