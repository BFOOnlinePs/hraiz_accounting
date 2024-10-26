<table class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th>المستند</th>
            <th>التاريخ</th>
            <th>دائن</th>
            <th>مدين</th>
            <th>الرصيد</th>
            <th>الملاحظات</th>
            <th>البيان</th>
        </tr>
    </thead>
    <tbody>
        @php
            $sumCreditor = [];
            $sumDebtor = [];
            $amount = 0;
        @endphp

        @if ($data->isEmpty())
            <tr>
                <td colspan="7" class="text-center">لا توجد بيانات</td>
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
            @foreach ($data as $key)
                @php
                    $currencySymbol = $key->currency_info->currency_symbol ?? 'بدون عملة';
                    // Initialize sums for this currency if not already set
                    if (!isset($sumCreditor[$currencySymbol])) {
                        $sumCreditor[$currencySymbol] = 0;
                    }
                    if (!isset($sumDebtor[$currencySymbol])) {
                        $sumDebtor[$currencySymbol] = 0;
                    }
                @endphp
                <tr>
                    <td>{{ $key->reference_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($key->created_at)->format('Y-m-d') }}</td>
                    <td>
                        @if (
                            $key->type == 'purchase' ||
                                $key->type == 'payment_bond' ||
                                $key->type == 'return_sales' ||
                                $key->type == 'registration_bond_credit')
                            {{ $key->amount }} {{ $currencySymbol }}
                            @php
                                $sumCreditor[$currencySymbol] += $key->amount; // Update creditor sum
                                $amount -= $key->amount;
                            @endphp
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        @if (
                            $key->type == 'sales' ||
                                $key->type == 'performance_bond' ||
                                $key->type == 'return_purchase' ||
                                $key->type == 'registration_bond_debt')
                            {{ $key->amount }} {{ $currencySymbol }}
                            @php
                                $sumDebtor[$currencySymbol] += $key->amount; // Update debtor sum
                                $amount += $key->amount;
                            @endphp
                        @else
                            0
                        @endif
                    </td>
                    <td>{{ $amount }}</td>
                    <td>{{ $key->invoice->note }}</td>
                    <td>
                        @if ($key->type == 'sales')
                            <a href="{{ route('accounting.purchase_invoices.invoice_view', ['id' => $key->invoice_id]) }}"
                                target="_blank">فاتورة مبيعات</a>
                        @elseif($key->type == 'payment_bond')
                            <a href="{{ route('accounting.purchase_invoices.invoice_view', ['id' => $key->invoice_id]) }}"
                                target="_blank">سند قبض</a>
                        @elseif($key->type == 'return_sales')
                            <a
                                href="{{ route('accounting.purchase_invoices.invoice_view', ['id' => $key->invoice_id]) }}">مردود
                                مبيعات</a>
                        @elseif($key->type == 'purchase')
                            <a
                                href="{{ route('accounting.purchase_invoices.invoice_view', ['id' => $key->invoice_id]) }}">فاتورة
                                مشتريات</a>
                        @elseif($key->type == 'performance_bond')
                            <a
                                href="{{ route('accounting.purchase_invoices.invoice_view', ['id' => $key->invoice_id]) }}">سند
                                صرف</a>
                        @elseif($key->type == 'registration_bond_debt' || $key->type == 'registration_bond_credit')
                            <a
                                href="{{ route('accounting.purchase_invoices.invoice_view', ['id' => $key->invoice_id]) }}">سند
                                قيد</a>
                        @elseif($key->type == 'return_purchase')
                            <a
                                href="{{ route('accounting.purchase_invoices.invoice_view', ['id' => $key->invoice_id]) }}">مردود
                                مشتريات</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr class="bg-dark">
                <td></td>
                <td colspan="2" class="text-center justify-content-center align-content-center">المجموع حسب العملة
                </td>
                <td colspan="5">
                    @foreach ($sumCreditor as $currency => $total)
                        <div>{{ $currency }} (دائن): {{ $total }}</div>
                    @endforeach
                    <hr class="bg-white">
                    @foreach ($sumDebtor as $currency => $total)
                        <div>{{ $currency }} (مدين): {{ $total }}</div>
                    @endforeach
                </td>
            </tr>
            <tr class="bg-dark">
                <td></td>
                <td colspan="2" class="text-center">الإجمالي</td>
                <td colspan="5">
                    <div>الإجمالي: <span class="text-bold">{{ array_sum($sumDebtor) - array_sum($sumCreditor) }}</span>
                    </div>
                </td>
            </tr>
        @endif
    </tbody>
</table>

<div>
    @foreach ($sumQuery as $key)
        <span class="text-center" style="font-size: 12px">
            @if ($key->type == 'sales')
                عدد فواتير المبيعات {{ $key->type_count }}
            @endif
            @if ($key->type == 'purchases')
                عدد فواتير المشتريات {{ $key->type_count }}
            @endif
            @if ($key->type == 'payment_bond')
                عدد سندات القبض {{ $key->type_count }}
            @endif
            @if ($key->type == 'performance_bond')
                عدد سندات الصرف {{ $key->type_count }}
            @endif
            @if ($key->type == 'return_sales')
                عدد مردودات المبيعات {{ $key->type_count }}
            @endif
            @if ($key->type == 'return_purchase')
                عدد مردودات المشتريات {{ $key->type_count }}
            @endif
            @if ($key->type == 'order_sales')
                عدد مردودات المشتريات {{ $key->type_count }}
            @endif
            &nbsp;
        </span>
    @endforeach
</div>
