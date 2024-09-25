{{--<table class="table table-bordered table-hover table-sm">--}}
{{--    <thead>--}}
{{--    <tr>--}}
{{--        <th>المستند</th>--}}
{{--        <th>التاريخ</th>--}}
{{--        <th>دائن</th>--}}
{{--        <th>مدين</th>--}}
{{--        <th>الرصيد</th>--}}
{{--        <th>البيان</th>--}}
{{--    </tr>--}}
{{--    </thead>--}}
{{--    <tbody>--}}
{{--    @php--}}
{{--        $sumCreditor = 0;--}}
{{--        $sumDebtor = 0;--}}
{{--        $amount = 0;--}}
{{--    @endphp--}}
{{--    @if(empty($data))--}}
{{--        <tr>--}}
{{--            <td colspan="7" class="text-center">لا توجد بيانات</td>--}}
{{--        </tr>--}}
{{--    @else--}}
{{--        <tr>--}}
{{--            <td></td>--}}
{{--            <td></td>--}}
{{--            <td>--}}
{{--                0--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                0--}}
{{--            </td>--}}
{{--            <td></td>--}}
{{--            <td>رصيد اول المدة</td>--}}
{{--        </tr>--}}

{{--        @foreach($data as $key)--}}
{{--            <tr>--}}
{{--                <td>{{ $key->i_id }}</td>--}}
{{--                <td>{{ $key->created_at }}</td>--}}
{{--                <td>--}}
{{--                    @if($key->invoice_type == 'purchases' || $key->invoice_type == 'payment_bond')--}}
{{--                        {{ $key->total_rate }}--}}
{{--                        @php--}}
{{--                            $sumCreditor += $key->total_rate;--}}
{{--                            $amount -= $key->total_rate;--}}
{{--                        @endphp--}}
{{--                    @else--}}
{{--                        0--}}
{{--                    @endif--}}
{{--                </td>--}}
{{--                <td>--}}
{{--                    @if($key->invoice_type == 'sales' || $key->invoice_type == 'performance_bond')--}}
{{--                        {{ $key->total_rate }}--}}
{{--                        @php--}}
{{--                            $sumDebtor += $key->total_rate;--}}
{{--                            $amount += $key->total_rate;--}}
{{--                        @endphp--}}
{{--                    @else--}}
{{--                        0--}}
{{--                    @endif--}}
{{--                </td>--}}
{{--                <td>--}}
{{--                    {{ $amount }}--}}
{{--                </td>--}}
{{--                <td>--}}
{{--                    @if($key->invoice_type == 'sales')--}}
{{--                        فاتورة بيع--}}
{{--                    @elseif($key->invoice_type == 'purchases')--}}
{{--                        فاتورة مشتريات--}}
{{--                    @elseif($key->invoice_type == 'performance_bond')--}}
{{--                        سند صرف--}}
{{--                    @elseif($key->invoice_type == 'payment_bond')--}}
{{--                        سند قبض--}}
{{--                    @endif--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--    @endif--}}
{{--    <tr class="bg-dark">--}}
{{--        <td colspan="2" class="text-center">المجموع</td>--}}
{{--        <td>{{ $sumCreditor }}</td>--}}
{{--        <td>{{ $sumDebtor }}</td>--}}
{{--        <td>{{ $sumDebtor - $sumCreditor }}</td>--}}
{{--        <td></td>--}}
{{--    </tr>--}}
{{--    <tr>--}}


{{--        <td>{{ $invoiceCount->count }}</td>--}}
{{--                <td></td>--}}
{{--                <td></td>--}}
{{--                <td></td>--}}
{{--                <td></td>--}}
{{--                <td></td>--}}
{{--            </tr>--}}
{{--    </tbody>--}}
{{--</table>--}}

{{--<div >--}}
{{--    @foreach($invoiceCounts as $invoiceCount)--}}
{{--        <span class="text-center" style="font-size: 12px">--}}

{{--        @if($invoiceCount->invoice_type == 'sales')--}}

{{--                عدد فواتير المبيعات--}}
{{--                {{ $invoiceCount->count }}--}}
{{--            @endif--}}
{{--        @if($invoiceCount->invoice_type == 'purchases')--}}
{{--                عدد فواتير المشتريات--}}
{{--                {{ $invoiceCount->count }}--}}
{{--            @endif--}}
{{--        @if($invoiceCount->invoice_type == 'payment_bond')--}}
{{--                عدد سندات القبض--}}
{{--                {{ $invoiceCount->count }}--}}
{{--            @endif--}}
{{--        @if($invoiceCount->invoice_type == 'performance_bond')--}}
{{--                عدد سندات الصرف--}}
{{--                {{ $invoiceCount->count }}--}}
{{--            @endif--}}
{{--            &nbsp;--}}
{{--            </span>--}}

{{--    @endforeach--}}

{{--</div>--}}

<table class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th>المستند</th>
            <th>التاريخ</th>
            <th>دائن</th>
            <th>مدين</th>
            <th>الرصيد</th>
            <th>البيان</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @php
        $sumCreditor = 0;
        $sumDebtor = 0;
        $amount = 0;
    @endphp
    @if($data->isEmpty())
        <tr>
            <td colspan="6" class="text-center">لا توجد بيانات</td>
        </tr>
    @else
        <tr>
            <td></td>
            <td></td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>رصيد اول المدة</td>
            <td></td>
        </tr>
        @foreach($data as $key)
            <tr>
                <td>{{ $key->reference_number }}</td>
                <td>{{ \Carbon\Carbon::parse($key->created_at)->format('Y-m-d') }}</td>
                <td>
                    @if($key->type == 'purchase' || $key->type == 'payment_bond' || $key->type == 'return_sales' || $key->type == 'registration_bond_credit')
                        {{ $key->amount }}
                        @php
                            $sumCreditor += $key->amount;
                            $amount -= $key->amount;
                        @endphp
                    @else
                        0
                    @endif
                </td>
                <td>
                    @if($key->type == 'sales' || $key->type == 'performance_bond' || $key->type == 'return_purchase' || $key->type == 'registration_bond_debt')
                        {{ $key->amount }}
                        @php
                            $sumDebtor += $key->amount;
                            $amount += $key->amount;
                        @endphp
                    @else
                        0
                    @endif
                </td>
                <td>{{ $amount }}</td>
                <td>
                    @if($key->type == 'sales')
                        فاتورة مبيعات
                    @elseif($key->type == 'payment_bond')
                        سند قبض
                    @elseif($key->type == 'return_sales')
                        مردود مبيعات
                    @elseif($key->type == 'purchase')
                        فاتورة مشتريات
                    @elseif($key->type == 'performance_bond')
                        سند صرف
                    @elseif($key->type == 'registration_bond_debt')
                        سند قيد
                    @elseif($key->type == 'registration_bond_credit')
                        سند قيد
                    @elseif($key->type == 'return_purchase')
                        مردود مشتريات
                    @endif
                </td>
                <td>
{{--                    <a href="{{ route('accounting.purchase_invoices.invoice_view',['id'=>$key->invoice_id]) }}" class="btn btn-warning btn-sm"><span class="fa fa-search"></span></a>--}}
                </td>
            </tr>
        @endforeach
        <tr class="bg-dark">
            <td></td>
            <td colspan="" class="text-center">المجموع</td>
            <td>{{ $sumCreditor }}</td>
            <td>{{ $sumDebtor }}</td>
            <td>{{ $sumDebtor - $sumCreditor }}</td>
            <td></td>
            <td></td>
        </tr>
    @endif
    </tbody>
</table>

<div >
    @foreach($sumQuery as $key)
        <span class="text-center" style="font-size: 12px">

        @if($key->type == 'sales')

                عدد فواتير المبيعات
                {{ $key->type_count }}
            @endif
            @if($key->type == 'purchases')
                عدد فواتير المشتريات
                {{ $key->type_count }}
            @endif
            @if($key->type == 'payment_bond')
                عدد سندات القبض
                {{ $key->type_count }}
            @endif
            @if($key->type == 'performance_bond')
                عدد سندات الصرف
                {{ $key->type_count }}
            @endif
            @if($key->type == 'return_sales')
                عدد مردودات المبيعات
                {{ $key->type_count }}
            @endif
            @if($key->type == 'return_purchase')
                عدد مردودات المشتريات
                {{ $key->type_count }}
            @endif
            @if($key->type == 'order_sales')
                عدد مردودات المشتريات
                {{ $key->type_count }}
            @endif
            &nbsp;

        </span>

    @endforeach

</div>


