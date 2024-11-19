<table class="table table-sm table-hover w-100" style="font-size: 14px">
    <thead class="bg-dark">
        <tr>
            <th>رقم المرجعي للطلبية</th>
            <th>بواسطة</th>
            <th>الى الموظف</th>
            <th>حالة التحضير</th>
            <th>تاريخ الاضافة</th>
            <th style="width: 13%" class="text-center">العمليات</th>
        </tr>
    </thead>
    <tbody>
        @if ($data->isEmpty())
            <tr>
                <td colspan="8" class="text-center">لا يوجد بيانات</td>
            </tr>
        @else
            @foreach ($data as $key)
                <tr>
                    <td>{{ $key->order->reference_number }}</td>
                    <td>{{ $key->fromUser->name }}</td>
                    <td>{{ $key->toUser->name }}</td>
                    <td>
                        {{-- @if ($key->status == 'waiting_prepared')
                            <div class="badge badge-warning w-100"> بانتظار التجهيز
                            </div>
                        @elseif ($key->status == 'ready_prepared')
                            <div class="badge badge-info w-100">
                                تم التجهيز
                            </div>
                        @elseif ($key->status == 'delivered')
                            <div class="badge badge-success w-100">
                                تم التسليم
                            </div>
                        @endif --}}
                        <select
                            class="p-1 btn-xs @if ($key->status == 'delivered') bg-success @elseif ($key->status == 'ready_prepared') bg-info @else bg-warning @endif"
                            style="width:100%" onchange="update_status_preparation({{ $key->id }} , this.value)"
                            name="" id="">
                            <option @if ($key->status == 'waiting_prepared') selected @endif value="waiting_prepared">بانتظار
                                التجهيز</option>
                            <option @if ($key->status == 'ready_prepared') selected @endif value="ready_prepared">تم التجهيز
                            </option>
                            <option @if ($key->status == 'delivered') selected @endif value="delivered">تم التسليم
                            </option>
                        </select>
                    </td>
                    <td>{{ $key->insert_at }}</td>
                    <td class="text-center">
                        <a href="{{ route('accounting.preparation.details', ['preparation_id' => $key->id]) }}"
                            class="btn btn-info btn-sm" style="font-size: 10px">الدخول الى
                            الطلبية</a>
                        {{-- <a href="{{ route('accounting.preparation.print_qr_code_pdf', ['id' => $key->id]) }}"
                            class="btn btn-warning btn-sm"><span class="fa fa-barcode"></span></a> --}}
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
