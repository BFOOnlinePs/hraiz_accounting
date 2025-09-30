<table class="table table-bordered table-hover table-sm">
    <thead class="bg-dark">
        <tr>
            <th>المستند</th>
            <th>التاريخ</th>
            <th>دائن</th>
            <th>مدين</th>
            <th>الرصيد</th>
            <th>الملاحظات</th>
            <th style="width: 200px">البيان</th>
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
            @if (!empty($firstTermBalance))
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        @if ($firstTermBalance['amount'] < 0)
                            {{ $firstTermBalance['amount'] }}
                        @else
                        0
                        @endif
                    </td>
                    <td>
                        @if ($firstTermBalance['amount'] > 0)
                            {{ $firstTermBalance['amount'] }}
                        @else
                        0
                        @endif
                    </td>
                    <td>{{ $firstTermBalance['amount'] }}</td>
                    <td>رصيد اول المدة  </td>
                    <td></td>
                </tr>
            @endif
            @foreach ($data as $key)
                @php
                    $currencySymbol = $key->currency_info->currency_symbol ?? 'بدون عملة';

                    // Initialize sums and balances for this currency if not already set
                    $sumCreditor[$currencySymbol] = $sumCreditor[$currencySymbol] ?? 0;
                    $sumDebtor[$currencySymbol] = $sumDebtor[$currencySymbol] ?? 0;
                    $balances[$currencySymbol] = $balances[$currencySymbol] ?? 0;
                @endphp

                <tr class="@if (!$key->invoice_items->isEmpty() && $request->account_statment_type == 'detailed') bg-secondary @endif">
                    <td>{{ $key->reference_number }}</td>
                    <td>
                        @if ($key->type == 'payment_bond' || $key->type == 'performance_bond')
                            {{ date('d-m-Y', strtotime($key->bond->created_at)) }}
                        @elseif ($key->type == 'purchase')
                            {{ $key->invoice->due_date ?? ' - ' }}
                        @elseif ($key->type == 'sales')
                            {{ $key->invoice->bill_date ?? ' - ' }}
                        @endif
                    </td>
                    <td>
                        @if (in_array($key->type, ['purchase', 'payment_bond', 'return_sales', 'registration_bond_credit']))
                            {{ $currencySymbol }} {{ $key->amount }}
                            @php
                                $sumCreditor[$currencySymbol] += $key->amount;
                                $balances[$currencySymbol] -= $key->amount;
                            @endphp
                        @else
                            {{ $currencySymbol }} 0
                        @endif
                    </td>
                    <td>
                        @if (in_array($key->type, ['sales', 'performance_bond', 'return_purchase', 'registration_bond_debt']))
                            {{ $currencySymbol }} {{ $key->amount }}
                            @php
                                $sumDebtor[$currencySymbol] += $key->amount;
                                $balances[$currencySymbol] += $key->amount;
                            @endphp
                        @else
                            {{ $currencySymbol }} 0
                        @endif
                    </td>
                    <td style="background-color: gainsboro">
                        @php
                            // Format balances for display with badge class
                            $balanceDisplay = collect($balances)
                                ->map(function ($value, $currency) {
                                    return '<span class="">' . $currency . ' ' . number_format($value) . '</span>';
                                })
                                ->join(' , ');
                        @endphp
                        <span style="font-weight: bold;">{!! $balanceDisplay !!}</span>
                    </td>
                    <td>
                        @if ($key->type == 'payment_bond' || $key->type == 'performance_bond')
                            {{ $key->bond->notes }}
                        @else
                            {{ $key->invoice->note ?? '' }}
                        @endif
                    </td>
                    <td>
                        @if ($key->type == 'sales')
                            <div style="width:13px;height:13px" class="bg-success d-inline-block ml-2 rounded"></div><a
                                class="text-dark" target="_blank"
                                href="{{ route('accounting.sales_invoices.invoice_view', ['id' => $key->invoice_id]) }}">فاتورة
                                مبيعات</a>
                        @elseif ($key->type == 'payment_bond')
                            <div style="width:13px;height:13px" class="bg-secondary d-inline-block ml-2 rounded"></div>
                            <a class="text-dark" target="_blank"
                                href="{{ route('accounting.bonds.details', ['id' => $key->invoice_id]) }}">
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
                            <div style="width:13px;height:13px" class="bg-danger d-inline-block ml-2 rounded"></div><a
                                class="text-dark" target="_blank"
                                href="{{ route('accounting.returns.returns_details', ['id' => $key->invoice_id]) }}">
                                <span>مردود مبيعات</span>
                                {{-- <span>{{ App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type ?? '' }}</span>
                                @if (!empty(App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type) && App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type == 'check')
                                    <span>( شيك )</span>
                                @endif --}}
                            </a>
                        @elseif($key->type == 'return_purchase')
                            <div style="width:13px;height:13px" class="bg-warning d-inline-block ml-2 rounded"></div><a
                                class="text-dark" target="_blank"
                                href="{{ route('accounting.returns.returns_details', ['id' => $key->invoice_id]) }}">
                                <span>مردود مشتريات</span>
                                {{-- <span>{{ App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type ?? '' }}</span>
                                @if (!empty(App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type) && App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type == 'check')
                                    <span>( شيك )</span>
                                @endif --}}
                            </a>
                        @elseif ($key->type == 'performance_bond')
                            <div style="width:13px;height:13px" class="bg-dark d-inline-block ml-2 rounded"></div><a
                                class="text-dark" target="_blank"
                                href="{{ route('accounting.bonds.details', ['id' => $key->invoice_id]) }}">
                                <span>سند صرف</span>
                                {{-- <span>{{ App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type ?? '' }}</span>
                                @if (!empty(App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type) && App\Models\BondsModel::where('invoice_id', $key->invoice_id)->first()->payment_type == 'check')
                                    <span>( شيك )</span>
                                @endif --}}
                            </a>
                        @elseif ($key->type == 'purchase')
                            <div style="width:13px;height:13px" class="bg-info d-inline-block ml-2 rounded"></div><a
                                class="text-dark" target="_blank"
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
                                    <table class="table-sm w-100">
                                        <tbody>
                                            @foreach ($key->invoice_items as $item)
                                                <tr>
                                                    <td style="width: 15%">{{ $item->product->barcode }}</td>
                                                    <td>{{ $item->product->product_name_ar }}</td>
                                                    <td style="width: 10%">{{ $item->quantity }}</td>
                                                    <td style="width: 10%">{{ $item->rate }}</td>
                                                    <td class="bg-success" style="width: 10%">
                                                        {{ $item->quantity * $item->rate }}</td>
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

            <tr class="bg-success">
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
                                else {
                                    $value = 0;
                                    return $value . '<br>';
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
