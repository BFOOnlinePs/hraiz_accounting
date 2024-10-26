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
            $balances = []; // To hold balance per currency
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

                    // Initialize sums and balances for this currency if not already set
                    $sumCreditor[$currencySymbol] = $sumCreditor[$currencySymbol] ?? 0;
                    $sumDebtor[$currencySymbol] = $sumDebtor[$currencySymbol] ?? 0;
                    $balances[$currencySymbol] = $balances[$currencySymbol] ?? 0;
                @endphp
                <tr>
                    <td>{{ $key->reference_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($key->created_at)->format('Y-m-d') }}</td>
                    <td>
                        @if (in_array($key->type, ['purchase', 'payment_bond', 'return_sales', 'registration_bond_credit']))
                            {{ $key->amount }} {{ $currencySymbol }}
                            @php
                                $sumCreditor[$currencySymbol] += $key->amount;
                                $balances[$currencySymbol] -= $key->amount;
                            @endphp
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        @if (in_array($key->type, ['sales', 'performance_bond', 'return_purchase', 'registration_bond_debt']))
                            {{ $key->amount }} {{ $currencySymbol }}
                            @php
                                $sumDebtor[$currencySymbol] += $key->amount;
                                $balances[$currencySymbol] += $key->amount;
                            @endphp
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        @php
                            // Format balances for display with badge class
                            $balanceDisplay = collect($balances)
                                ->map(function ($value, $currency) {
                                    return '<span class="badge bg-warning">' .
                                        number_format($value) .
                                        ' ' .
                                        $currency .
                                        '</span>';
                                })
                                ->join(' , ');
                        @endphp
                        {!! $balanceDisplay !!}
                    </td>
                    <td>{{ $key->notes ?? '' }}</td>
                    <td>
                        <!-- Add links as per transaction type -->
                        <!-- Omitted for brevity -->
                    </td>
                </tr>
            @endforeach

            <tr class="bg-dark">
                <td></td>
                <td colspan="1" class="text-center">المجموع</td>
                <td>
                    @php
                        $creditorDisplay = collect($sumCreditor)
                            ->map(function ($total, $currency) {
                                return $currency . ' ' . number_format($total) . '<br>';
                            })
                            ->join('');
                    @endphp
                    {!! $creditorDisplay !!}
                </td>
                <td>
                    @php
                        $debtorDisplay = collect($sumDebtor)
                            ->map(function ($total, $currency) {
                                return $currency . ' ' . number_format($total) . '<br>';
                            })
                            ->join('');
                    @endphp
                    {!! $debtorDisplay !!}
                </td>
                <td colspan="3">
                    @php
                        $balanceDisplay = collect($balances)
                            ->map(function ($value, $currency) {
                                return $currency . ' ' . number_format($value) . '<br>';
                            })
                            ->join('');
                    @endphp
                    {!! $balanceDisplay !!}
                </td>
            </tr>

            {{-- <tr class="bg-dark">
                <td></td>
                <td colspan="1" class="text-center">الإجمالي</td>
                <td colspan="6">
                    <div>الإجمالي:
                        @php
                            // حساب الرصيد الإجمالي وعرضه لكل عملة على حدة
                            $overallBalance = collect($balances)
                                ->map(function ($value, $currency) {
                                    return '<span class="badge bg-warning text-dark">' .
                                        number_format($value) .
                                        ' ' .
                                        $currency .
                                        '</span><br>'; // إضافة فاصل سطر بعد كل عملة
                                })
                                ->join('');
                        @endphp
                        {!! $overallBalance !!}
                    </div>
                </td>
            </tr> --}}
        @endif
    </tbody>
</table>

{{-- <div>
    @foreach ($sumQuery as $key)
        <span class="text-center" style="font-size: 12px">
            <!-- Display count of each type -->
            <!-- Omitted for brevity -->
        </span>
    @endforeach
</div> --}}
