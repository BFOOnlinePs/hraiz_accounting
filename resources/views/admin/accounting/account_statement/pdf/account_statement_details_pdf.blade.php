<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        @page {
            @if(!empty(\App\Models\SystemSettingModel::first()->letter_head_image))
                background-image: url("{{ asset('storage/setting/'.\App\Models\SystemSettingModel::first()->letter_head_image) }}");
            @endif
                        background-image-resize: 6;
            margin-top: 150px;
            margin-bottom: 50px;
            footer: page-footer;
        }

        @page :first {
            @if(!empty(\App\Models\SystemSettingModel::first()->letter_head_image))
                background-image: url("{{ asset('storage/setting/'.\App\Models\SystemSettingModel::first()->letter_head_image) }}");
            @endif
            background-image-resize: 6;
            margin-bottom: 50px;
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
        <thead class="bg-dark">
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
                    <tr class="@if(!$key->invoice_items->isEmpty() && $request->account_statment_type == 'detailed')
                        bg-dark
                    @endif">
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
                                            $currency .
                                            ' ' .
                                            number_format($value) .
                                            '</span>';
                                    })
                                    ->join(' , ');
                            @endphp
                            {!! $balanceDisplay !!}
                        </td>
                        <td>{{ $key->notes ?? '' }}</td>
                        <td>
                            @if ($key->type == 'sales')
                                <a target="_blank"
                                    href="{{ route('accounting.sales_invoices.invoice_view', ['id' => $key->invoice_id]) }}">فاتورة
                                    مبيعات</a>
                            @elseif ($key->type == 'payment_bond')
                            <a target="_blank" href="{{ route('accounting.bonds.details', ['id' => $key->invoice_id]) }}">
                                <span>سند قبض</span>
                                {{-- <span>{{ App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type ?? '' }}</span>
                                @if (!empty(App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type) && App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type == 'check')
                                    <span>( شيك )</span>
                                @endif --}}
                            </a>

                                {{-- <a target="_blank"
                                    href="{{ route('accounting.bonds.details', ['id' => $key->invoice_id]) }}"><span>سند
                                        قبض</span> --}}
                                {{-- <span>{{ App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type ?? '' }}</span>
                                    @if (!empty(App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type) && App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type == 'check')
                                        <span>( شيك )</span>
                                    @endif --}}
                                {{-- </a> --}}
                            @elseif($key->type == 'return_sales')
                                <a target="_blank" href="{{ route('accounting.returns.returns_details', ['id' => $key->invoice_id]) }}">
                                    <span>مردود مبيعات</span>
                                    {{-- <span>{{ App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type ?? '' }}</span>
                                    @if (!empty(App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type) && App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type == 'check')
                                        <span>( شيك )</span>
                                    @endif --}}
                                </a>
                            @elseif ($key->type == 'performance_bond')
                                <a target="_blank" href="{{ route('accounting.bonds.details', ['id' => $key->invoice_id]) }}">
                                    <span>سند صرف</span>
                                    {{-- <span>{{ App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type ?? '' }}</span>
                                    @if (!empty(App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type) && App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type == 'check')
                                        <span>( شيك )</span>
                                    @endif --}}
                                </a>
                            @elseif ($key->type == 'purchase')
                                <a target="_blank"
                                    href="{{ route('accounting.purchase_invoices.invoice_view', ['id' => $key->invoice_id]) }}">فاتورة
                                    مشتريات</a>
                            @elseif ($key->type == 'performance_bond')
                            @endif
                        </td>
                    </tr>

                    @if ($key->type == 'sales' || $key->type == 'purchase')
                        @if ($request->account_statment_type == 'detailed')
                            @if (!empty($key->invoice_items))
                                <tr class="bg-light">
                                    <td colspan="7">
                                        <table class="table-sm w-100" style="width: 100%">
                                            <tbody>
                                                @foreach ($key->invoice_items as $item)
                                                    <tr>
                                                        <td style="width: 15%">{{ $item->product->barcode }}</td>
                                                        <td>{{ $item->product->product_name_ar }}</td>
                                                        <td style="width: 10%">{{ $item->quantity }}</td>
                                                        <td style="width: 10%">{{ $item->rate }}</td>
                                                        <td class="bg-success" style="width: 10%">{{ $item->quantity * $item->rate }}</td>
                                                    </tr>
                                                @endforeach

                                            </tbody>

                                        </table>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endif
                @endforeach

                <tr class="bg-dark">
                    <td></td>
                    <td colspan="1" class="text-center">المجموع</td>
                    <td>
                        @php
                            $creditorDisplay = collect($sumCreditor)
                                ->map(function ($total, $currency) {
                                    if ($total != 0) {
                                        return $currency . ' ' . number_format($total) . '<br>';
                                    }
                                })
                                ->join('');
                        @endphp
                        {!! $creditorDisplay !!}
                    </td>
                    <td>
                        @php
                            $debtorDisplay = collect($sumDebtor)
                                ->map(function ($total, $currency) {
                                    if ($total != 0) {
                                        return $currency . ' ' . number_format($total) . '<br>';
                                    }
                                })
                                ->join('');
                        @endphp
                        {!! $debtorDisplay !!}
                    </td>
                    <td colspan="3">
                        @php
                            $balanceDisplay = collect($balances)
                                ->map(function ($value, $currency) {
                                    if ($value != 0) {
                                        return $currency . ' ' . number_format($value) . '<br>';
                                    }
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


</body>

</html>
