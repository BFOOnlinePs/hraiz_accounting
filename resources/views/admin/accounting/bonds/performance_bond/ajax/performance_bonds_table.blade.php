<table class="w-100 text-center table-bordered table-hover table-striped">
    <thead class="bg-dark">
        <tr>
            <th style="width: 50px">#</th>
            <th style="width: 15%">الرقم المرجعي</th>
            <th style="width: 15%">القيمة</th>
            <th style="width: 100px">العملة</th>
            <th style="width: 15%">نوع الدفعة</th>
            <th style="width: 15%">اضيفت بواسطة</th>
            <th style="width: 15%">العميل</th>
            <th style="width: 17%">الملاحظات</th>
            <th style="width: 100px">العمليات</th>
        </tr>
    </thead>
    <tbody>
        @if ($data->isEmpty())
            <tr>
                <td colspan="9" class="text-center">لا توجد بيانات</td>
            </tr>
        @else
            @foreach ($data as $key)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $key->reference_number }}</td>
                    <td>{{ $key->amount }}</td>
                    <td>{{ $key->currency->currency_name }}</td>
                    <td>
                        @if ($key->payment_type == 'cash')
                            <small class="badge badge-info w-100">كاش</small>
                        @else
                            <small data-toggle="modal" data-target="#update_check_payment_type_modal" onclick="get_check_data({{ $key }})" class="badge badge-warning w-100"><span>شيك </span><span

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
                    <td>{{ $key->notes }}</td>

                    <td>
                        <a href="{{ route('accounting.bonds.details', ['id' => $key->id]) }}"
                            class="btn btn-xs btn-dark"><span class="fa fa-search"></span></a> <a
                            href="{{ route('accounting.bonds.performance_bond.edit_performance_bonds', ['id' => $key->id]) }}"
                            {{-- class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                        <a href="" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a> --}} </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
