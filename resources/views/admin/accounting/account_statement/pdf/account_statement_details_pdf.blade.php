<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        @page {
            @if (!empty($system_setting))
                background-image: url("{{ asset('storage/setting/' . $system_setting->letter_head_image) }}");
            @endif
            background-image-resize: 6;
            header: page-header;
            footer: page-footer;
            margin-top: 200px;
        }

        @page :first {
            @if (!empty($system_setting))
                background-image: url("{{ asset('storage/setting/' . $system_setting->letter_head_image) }}");
            @endif
            background-image-resize: 6;
            margin-top: 15%;
            /*margin-bottom: 50px;*/
            /*margin-top: 220px;*/
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
            color: #212529;
            font-size: 0.50rem;
            text-align: center
                /* تصغير حجم الخط */
        }

        .table th,
        .table td {
            padding: 0.5rem;
            /* تقليل الحشو */
            vertical-align: top;
            border: 1px solid #dee2e6;
        }

        .table th {
            background-color: #5a5858;
            /* لون خلفية عناوين الجدول */
            color: white;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
            /* لون خلفية الصفوف بالتناوب */
        }

        .table tbody tr:hover {
            background-color: #d1e7dd;
            /* لون خلفية الصف عند التمرير */
        }

        .badge {
            padding: 0.5em;
            border-radius: 0.2em;
            font-size: 0.75rem;
            /* حجم خط الشارات */
        }
    </style>
</head>

<body>


    <table class="table table-bordered table-hover table-sm">
        <thead>
            <tr>
                <th>المستند</th>
                <th style="width: 14%;">التاريخ</th>
                <th style="width: 14%;">دائن</th>
                <th style="width: 14%;">مدين</th>
                <th style="width: 14%;">الرصيد</th>
                <th style="width: 14%;">الملاحظات</th>
                <th style="width: 14%;">البيان</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sumCreditor = [];
                $sumDebtor = [];
                $balances = [];
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
                                $balanceDisplay = collect($balances)
                                    ->map(function ($value, $currency) {
                                        return $currency . ' ' . number_format($value) . '<br>';
                                    })
                                    ->join(' , ');
                            @endphp
                            {!! $balanceDisplay !!}
                        </td>
                        <td>{{ $key->notes ?? '' }}</td>
                        <td>
                            @if ($key->type == 'sales')
                                مبيعات
                            @elseif ($key->type == 'purchase')
                                مشتريات
                            @endif
                        </td>
                    </tr>
                @endforeach

                <tr class="bg-dark text-white">
                    <td colspan="2" class="text-center">المجموع</td>
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
                    <td colspan="1">
                        @php
                            $balanceDisplay = collect($balances)
                                ->map(function ($value, $currency) {
                                    return $currency . ' ' . number_format($value) . '<br>';
                                })
                                ->join('');
                        @endphp
                        {!! $balanceDisplay !!}
                    </td>
                    <td colspan="2"></td>
                </tr>
            @endif
        </tbody>
    </table>

</body>

</html>
